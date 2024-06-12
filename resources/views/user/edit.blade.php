@extends('layouts.master')

@section('title')
    @lang('user.edit_title')
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
            @lang('user.edit_title')
        @endslot
        @slot('title')
            @lang('user.edit_title')
        @endslot
    @endcomponent

    @php
        $branch = App\Models\branch_info::all();
    @endphp

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('user.update',$data->id)}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="name">Branch</label>
                                <select class="form-control" name="branch" id="branch" required>
                                    <option>--Select One--</option>
                                    @if($branch)
                                    @foreach ($branch as $v)
                                        <option @if($v->id == $data->branch) selected @endif value="{{$v->id}}">{{$v->branch_name_en}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="name">@lang('common.name')</label>
                                <input name="name" type="text" class="form-control" id="name" placeholder="Type User Name"
                                     required value="{{$data->name}}">
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="email">@lang('common.email')</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Type User Email"
                                     required value="{{$data->email}}">
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="mobile">@lang('common.mobile')</label>
                                <input name="mobile" type="text" class="form-control" id="mobile" placeholder="Type User Mobile"
                                    value="{{$data->mobile}}">
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label class="form-label fw-bold" for="userdob">@lang('common.dob')</label>
                                <input name="dob" type="text" class="form-control @error('dob') is-invalid @enderror"
                                    placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container='#datepicker1'
                                    data-date-end-date="0d" value=""
                                    data-provide="datepicker" autofocus id="dob" value="{{$data->dob}}">
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <div class="form-group">
                                    <label>@lang('user.role')</label>
                                    <select class="form-control" name="role_id" id="role_id">
                                        @if($roles)
                                        @foreach ($roles as $v)
                                        <option value="{{$v->id}}">{{$v->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
                                <label for="image">@lang('user.image')</label>
                                <input type="file" class="form-control" name="image" id="image">
                                <img src="{{asset('profile_images')}}/{{$data->picture}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" class="btn btn-sm btn-success" value="@lang('common.submit')">
                        </div>
                    </form>
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
                        toastr.success('Success', 'User Updated Successfully', {
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
