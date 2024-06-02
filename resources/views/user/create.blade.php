@extends('layouts.master')

@section('title')
    @lang('user.create_title')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link')
            {{ route('user.index') }}
        @endslot
        @slot('li_1')
            @lang('user.index_title')
        @endslot
        @slot('li_2')
            @lang('user.create_title')
        @endslot
        @slot('title')
            @lang('user.create_title')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['url' => route('user.store'), 'method' => 'post', 'class' => 'form needs-validation', 'novalidate', 'enctype' => 'multipart/form-data']) }}
                    @include('user.form')
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer_scripts')
    <script>
        $(document).ready(function() {
            $(".form").on('submit', (function(e) {
                e.preventDefault();

                /*------Remove previous validation messages------*/
                $('input').removeClass('is-invalid').next().remove('.ajax-error');
                $('select').removeClass('is-invalid').next().remove('.ajax-error');
                $('textarea').removeClass('is-invalid').next().remove('.ajax-error');

                let formData = new FormData(this)
                formData.append('image_remote_url', image_remote_url)
                formData.append('image_real_name', image_real_name)

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        toastr.success('Success', 'User Added Successfully', {
                            closeButton: true,
                            progressBar: true,
                            preventDuplicates: true
                        });

                        if (!$('#stay_here').is(":checked")) {
                            setTimeout(function() {
                                window.location.href =
                                    '{{ route('user.index') }}'
                            }, 1000);
                        }

                        $(".form").trigger("reset"); // to reset form input fields

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
@endpush
