@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xxl-4 col-lg-5">
            <div class="card">
                <!-- Logo -->
                <div class="card-header pt-4 pb-4 text-center bg-primary">
                    <a href="/">
                        <span><img src="{{ asset('assets/images/logo.png') }}" alt="" height="18"></span>
                    </a>
                </div>

                <div class="card-body p-4">

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <span>{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="text-center w-75 m-auto">
                        <h4 class="text-dark-50 text-center mt-0 fw-bold">Reset Password</h4>
                        <p class="text-muted mb-4">Enter your email address and we'll send you an email with instructions to reset your password.</p>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input name="email" class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                        </div>

                        <div class="mb-0 text-center">
                            <button class="btn btn-primary" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div> <!-- end card-body-->
            </div>
            <!-- end card -->

            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="text-muted">Back to <a href="{{ route('login') }}" class="text-muted ms-1"><b>Log In</b></a></p>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- end col -->
    </div>
    <!-- end row -->
</div>
@endsection
