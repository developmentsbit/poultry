@extends('frontend.Layouts.master')
@section('body')
<div class="container-xxl py-5 bg-primary hero-header mb-5">
    <div class="container my-5 py-5 px-lg-5">
        <div class="row g-5 py-5">
            <div class="col-12 text-center">
                <h1 class="text-white animated zoomIn">About Us</h1>
                <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">About</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Navbar & Hero End -->


<!-- Full Screen Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1">
<div class="modal-dialog modal-fullscreen">
    <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);">
        <div class="modal-header border-0">
            <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex align-items-center justify-content-center">
            <div class="input-group" style="max-width: 600px;">
                <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Full Screen Search End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="row g-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="section-title position-relative mb-4 pb-2">
                    <h6 class="position-relative text-primary ps-4">About Us</h6>
                    <h2 class="mt-2">{{$about_us->title}}</h2>
                </div>
                <p class="mb-4">{!! $about_us->description !!}</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Award Winning</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Professional Staff</h6>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>24/7 Support</h6>
                        <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Fair Prices</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-4">
                    <a class="btn btn-primary rounded-pill px-4 me-3" href="{{url('/about-us')}}">Read More</a>
                <a class="btn btn-outline-primary btn-square me-3" href="{{$wb_content->facebook}}"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-outline-primary btn-square me-3" href="{{$wb_content->twiiter}}"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-outline-primary btn-square me-3" href="{{$wb_content->instagram}}"><i class="fab fa-instagram"></i></a>
                <a class="btn btn-outline-primary btn-square" href="{{$wb_content->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- About End -->


<!-- Newsletter Start -->
<div class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
<div class="container px-lg-5">
    <div class="row align-items-center" style="height: 250px;">
        <div class="col-12 col-md-6">
            <h3 class="text-white">Ready to get started</h3>
            <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
            <div class="position-relative w-100 mt-3">
                <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Enter Your Email" style="height: 48px;">
                <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
            </div>
        </div>
        <div class="col-md-6 text-center mb-n5 d-none d-md-block">
            <img class="img-fluid mt-5" style="height: 250px;" src="{{asset('Frontend/img')}}/newsletter.png">
        </div>
    </div>
</div>
</div>
<!-- Newsletter End -->


<!-- Team Start -->
<div class="container-xxl py-5">
<div class="container px-lg-5">
    <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="position-relative d-inline text-primary ps-4">Our Team</h6>
        <h2 class="mt-2">Meet Our Team Members</h2>
    </div>
    <div class="row g-4">
        @if($our_team)
        @foreach ($our_team as $v)

        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="team-item">
                <div class="d-flex">
                    <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5" style="width: 75px;">
                        <a class="btn btn-square text-primary bg-white my-1" href="{{$v->facebook}}"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href="{{$v->twitter}}"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href="{{$v->instagram}}"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href="{{$v->linked_in}}"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                    <img class="img-fluid rounded w-100" src="{{asset('Frontend/img/TeamMember')}}/{{$v->image}}" alt="{{$v->member_name}}">
                </div>
                <div class="px-4 py-3">
                    <h5 class="fw-bold m-0">{{$v->member_name}}</h5>
                    <small>{{$v->designation}}</small>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
</div>
<!-- Team End -->
@endsection
