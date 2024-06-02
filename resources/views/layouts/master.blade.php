<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$website_info->company_name_en}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin panel which can be used to manage huge system." name="description">
    <meta content="Najran BD PVT LTD" name="author">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('inventory/logo') }}/{{$website_info->logo}}">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<style>
    .select2-container--default .select2-selection--single{
        border: 1px solid lightgray !important;
        border-radius: 0px !important;
    }
    table tr th{
        padding : 5px 7px !important;
    }
    .bg-dark{
        background: #313a46 !important;
    }
    #showdata tr td{
padding: 2px 3px;
}
</style>



    @include('layouts.header_scripts')

    @stack('header_styles')

</head>

@php

    $path = request()->path();

    $explode = explode('/',$path);



@endphp

@if(request()->path() === 'purchase/create' || request()->path() === 'sales/create' || request()->path() === 'purchase_with_sales')
<body class="loading"
data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":true, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
@else
<body class="loading"
data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>

@endif
    <div class="wrapper">

        @include('layouts.left_sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                @include('layouts.navbar')

                @yield('content')

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Skill Based IT - SBIT
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About Us</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!--  Change-Password -->
    <div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.change-password') }}" method="POST" id="change-password">
                        @csrf
                        <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">
                        <div class="mb-3">
                            <label for="current_password">Current Password</label>
                            <input name="current_password" id="current-password" type="password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                autocomplete="current_password" placeholder="Enter Current Password"
                                value="{{ old('current_password') }}">
                            <div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="newpassword">New Password</label>
                            <input name="password" id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" autocomplete="new_password"
                                placeholder="Enter New Password">
                            <div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
                        </div>

                        <div class="mb-3">
                            <label for="userpassword">Confirm Password</label>
                            <input name="password_confirm" id="password-confirm" type="password" class="form-control"
                                autocomplete="new_password" placeholder="Enter New Confirm password">
                            <div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdatePassword"
                                type="submit">Update Password</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--  Update Profile / Settings -->
    <div class="modal fade update-profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.profile-update') }}" class="form-horizontal" method="POST"
                        enctype="multipart/form-data" id="update-profile">
                        @csrf
                        <input name="user_id" type="hidden" value="{{ Auth::user()->id }}" id="data_id">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ Auth::user()->name }}" id="name" name="name" autofocus
                                placeholder="Enter name">
                            <div class="text-danger" id="nameError" data-ajax-feedback="name"></div>
                        </div>

                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="useremail" value="{{ Auth::user()->email }}" name="email"
                                placeholder="Enter email" autofocus>
                            <div class="text-danger" id="emailError" data-ajax-feedback="email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ Auth::user()->mobile }}" id="mobile" name="mobile" autofocus
                                placeholder="Enter mobile">
                            <div class="text-danger" id="mobileError" data-ajax-feedback="mobile"></div>
                        </div>

                        <div class="mb-3">
                            <label for="userdob">Date of Birth</label>
                            <div class="input-group" id="datepicker1">
                                <input type="text" class="form-control @error('dob') is-invalid @enderror"
                                    placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy"
                                    data-date-container='#datepicker1' data-date-end-date="0d"
                                    value="{{ date('d-m-Y', strtotime(Auth::user()->dob)) }}"
                                    data-provide="datepicker" name="dob" autofocus id="dob">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                            <div class="text-danger" id="dobError" data-ajax-feedback="dob"></div>
                        </div>

                        <div class="mb-3">
                            <label for="picture">Profile Picture</label>
                            <div class="input-group">
                                <input type="file" class="form-control @error('picture') is-invalid @enderror"
                                    id="profile_image" name="image" autofocus onchange="preview_profile_image(this)">
                                <label class="input-group-text" for="picture">Upload</label>
                            </div>
                            <div class="text-start mt-2 text-center">
                                <img id="profile_image_preview" src="{{ auth()->user()->picture ? asset('storage/profile_images/' . auth()->user()->picture) : asset('assets/images/users/avatar_blank.png') }}" alt=""
                                    class="rounded-circle avatar-lg">
                            </div>
                            <div class="text-danger" role="alert" id="avatarError" data-ajax-feedback="picture">
                            </div>
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light UpdateProfile"
                                data-id="{{ Auth::user()->id }}" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>

        //profile_image preview
        function preview_profile_image(input){
            let file = $("#profile_image").get(0).files[0];

            if(file){
                let reader = new FileReader();

                reader.onload = function(){
                    $("#profile_image_preview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

    </script>



<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-single2').select2();
});
</script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-single3').select2();
});
</script>


{{-- <script>
    $(document).ready(function() {
        // alert(new Date().toDateInputValue());
        console.log(new Date().toDateInputValue());
        // $('.date').val(new Date().toDateInputValue());
    });
</script> --}}

    @include('layouts.right_sidebar')

    @include('layouts.footer_scripts')

    @stack('footer_scripts')

</body>

</html>

