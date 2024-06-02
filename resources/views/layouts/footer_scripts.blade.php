<script src="{{asset('assets')}}/js/vendor.min.js"></script>
<script src="{{asset('assets')}}/js/app.min.js"></script>
<!-- quill js -->
<script src="{{asset('assets')}}/js/vendor/quill.min.js"></script>
<!-- Init js-->
<script src="{{asset('assets')}}/js/pages/demo.quilljs.js"></script>

<!-- SimpleMDE js -->
<script src="{{asset('assets')}}/js/vendor/simplemde.min.js"></script>

<!-- SimpleMDE demo -->
<script src="{{asset('assets')}}/js/pages/demo.simplemde.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js"
    integrity="sha512-2bMhOkE/ACz21dJT8zBOMgMecNxx0d37NND803ExktKiKdSzdwn+L7i9fdccw/3V06gM/DBWKbYmQvKMdAA9Nw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
    integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/ui/component.fileupload.js') }}"></script>

<script>
    //ajax status update code
    function statusUpdate(id, url) {
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function(response) {
                if (response) {
                    toastr.success('Status Updated', 'Success')
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr, status, error)
            }
        });
    }


    function backend_errors(errors) {
        for (const [index, error] of errors.entries()) {

            if (index === 0) {
                $('html, body').animate({
                    scrollTop: $('input[name=' + error[0] + '], select[name=' + error[0] + '], textarea[name=' +
                        error[0] + ']').offset().top - 200
                }, 500);
            }

            const input = $('input[name=' + error[0] + ']');
            input.addClass('is-invalid')
            input.after(
                '<p class="text-danger ajax-error">' + error[1] + '</p>'
            );

            const select = $('select[name=' + error[0] + ']');
            select.addClass('is-invalid')
            select.after(
                '<p class="text-danger ajax-error">' + error[1] + '</p>'
            );

            const textarea = $('textarea[name=' + error[0] + ']');
            textarea.addClass('is-invalid')
            textarea.after(
                '<p class="text-danger ajax-error">' + error[1] + '</p>'
            );

            toastr.error(error[1], {
                closeButton: true,
                progressBar: true,
                preventDuplicates: true
            });
        }
    }
</script>

<script>
    $(document).ready(function() {
        $("#change-password").on('submit', (function(e) {
            e.preventDefault();

            /*------Remove previous validation messages------*/
            $('input').removeClass('is-invalid').next().remove('.ajax-error');
            $('select').removeClass('is-invalid').next().remove('.ajax-error');
            $('textarea').removeClass('is-invalid').next().remove('.ajax-error');

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    toastr.success('Success', 'Password Changed Successfully', {
                        closeButton: true,
                        progressBar: true,
                        preventDuplicates: true
                    });

                    if (!$('#stay_here').is(":checked")) {
                        setTimeout(function() {
                            window.location.href =
                                '{{ route('dashboard') }}'
                        }, 1000);
                    }

                    $("#change-password").trigger(
                        "reset"); // to reset form input fields

                },
                error: function(xhr, status, exception) {
                    setTimeout(function() {
                        $('#preloader').fadeOut(500);
                    }, 280);
                    console.log(xhr.responseJSON)

                    if (exception === 'Bad Request') {
                        console.log(xhr.responseJSON.errors)

                        toastr.error("Something Wrong! Try Again Please!", {
                            closeButton: true,
                            progressBar: true,
                            preventDuplicates: true
                        });

                    } else {
                        let errors = Object.entries(xhr.responseJSON.errors);
                        console.log(errors)

                        /*------Validation Messages------*/
                        backend_errors(errors)
                    }
                    $('.preloader').hide();
                }
            });
        }));
    });
</script>



