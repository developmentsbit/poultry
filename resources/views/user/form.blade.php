@push('header_styles')
    <style>
        /* Making a round cropping frame. This CSS also rounds the preview image. */
        .uploadcare--jcrop-holder>div>div,
        #preview {
            border-radius: 50%;
        }

        /* Styles and stuff for the page */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: sans-serif;
        }

        #preview {
            margin-top: 1rem;
        }

        p {
            text-align: center;
            max-width: 600px;
            padding: 1em;
            background: #eee;
        }

        h1 {
            text-align: center;
        }
    </style>
@endpush

<div class="row mb-3">

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="dripicons-wrong me-2"></i> {{ $errors->first() }}
        </div>
    @endif

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="name">Branch</label>
        <select class="form-control" name="branch" id="branch" required>
            <option>--Select One--</option>
            @if($branch)
            @foreach ($branch as $v)
                <option value="{{$v->id}}">{{$v->branch_name_en}}</option>
            @endforeach
            @endif
        </select>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="name">Name</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Type User Name"
            value="{{ @$user->name }}" required>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="email">Email</label>
        <input name="email" type="text" class="form-control" id="email" placeholder="Type User Email"
            value="{{ @$user->email }}" required>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="mobile">Mobile</label>
        <input name="mobile" type="text" class="form-control" id="mobile" placeholder="Type User Mobile"
            value="{{ @$user->mobile }}">
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="userdob">Date of Birth</label>
        <input name="dob" type="text" class="form-control @error('dob') is-invalid @enderror"
            placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container='#datepicker1'
            data-date-end-date="0d" value="{{ @$user->dob ? date('d-m-Y', strtotime(@$user->dob)) : '' }}"
            data-provide="datepicker" autofocus id="dob">
    </div>

    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
        <label class="form-label fw-bold" for="role_id">@lang('user.role')</label>
        <div class="form-group">
            {{ Form::select('role_id', $roles, @$user->user_roles?->first()->id, ['class' => @$error_class . 'form-control select2', 'id' => 'role_id', 'placeholder' => trans('common.select_one'), 'required']) }}
            @if ($errors->has('role_id'))
                <p class="text-danger">{{ $errors->first('role_id') }}</p>
            @endif
        </div>
    </div>

    @if (!@$user)
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 py-2">
            <label class="form-label fw-bold" for="password">Password</label>
            <input name="password" type="text" class="form-control" id="password" placeholder="Type User Password"
                value="" required>
        </div>
    @endif

    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 py-2">
        <!--
Uploadcare public key identifies a target project for uploads.
This pen uses "demopublickey" which points to the demo account.
Note, all files get deleted from that account every few hours.
-->
        <div class="border text-center">
            <div>
                <label class="form-label fw-bold" for="picture">Profile Image</label>
            </div>
            <!-- The input element below will turn into the widget -->
            <input type="hidden" role="uploadcare-uploader" data-crop="1:1" data-images-only>
            <!-- Your preview will be put here -->
            <div>
                <img src="" alt="" id="preview" width=200 height=200 />
            </div>
        </div>
    </div>

    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> Submit
        </button>
    </div>

    {{-- <div class="col-sm-3">
        @php $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label fw-bold">@lang('role.label_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => 1]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-3">
        @php $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label fw-bold">@lang('role.label_bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => 1]) }}
            @if ($errors->has('bn_name'))
                <p class="text-danger">{{$errors->first('bn_name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-3">
        @php $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label fw-bold">@lang('role.label_status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', 'Active',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('role.label_status_active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', 'Inactive',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('role.label_status_inactive')
                </label>
            </div>
            @if ($errors->has('status'))
                <p class="text-danger">{{$errors->first('status')}}</p>
            @endif
        </div>
    </div> --}}

</div>

@push('footer_scripts')
    <script>
        UPLOADCARE_PUBLIC_KEY = "demopublickey";
    </script>
    <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js" charset="utf-8"></script>

    <script>
        let image_remote_url = ''
        let image_real_name = ''

        // Getting an instance of the widget.
        const widget = uploadcare.Widget('[role=uploadcare-uploader]');
        // Selecting an image to be replaced with the uploaded one.
        const preview = document.getElementById('preview');
        // "onUploadComplete" lets you get file info once it has been uploaded.
        // "cdnUrl" holds a URL of the uploaded file: to replace a preview with.
        widget.onUploadComplete(fileInfo => {
            preview.src = fileInfo.cdnUrl;

            image_remote_url = fileInfo.cdnUrl
            image_real_name = fileInfo.name
            // console.log('fileInfo', fileInfo)
        })
        // Start upload preview image
        $(".gambar").attr("src", "https://i.ibb.co/kyJxfDd/555-guy-train-floydworx.png");
        var $uploadCrop,
            tempFilename,
            rawImg,
            imageId;

        function readFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                // swal("Sorry - you're browser doesn't support the FileReader API");
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 125,
                height: 125,
                type: 'circle'
            },
            enforceBoundary: false,
            enableExif: true
        });
        $('#cropImagePop').on('shown.bs.modal', function() {
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function() {
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function() {
            imageId = $(this).data('id');
            tempFilename = $(this).val();
            $('#cancelCropBtn').data('id', imageId);
            readFile(this);
        });
        $('#cropImageBtn').on('click', function(ev) {
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'jpeg',
                size: {
                    width: 125,
                    height: 125
                }
            }).then(function(resp) {
                $('#item-img-output').attr('src', resp);
                $('#cropImagePop').modal('hide');
            });
        });
        // End upload preview image
    </script>
@endpush
