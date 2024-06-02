@extends('frontend.Layouts.master')
@section('body')
<div class="container-xxl py-5 bg-primary hero-header mb-5">
    <div class="container my-5 py-5 px-lg-5">
        <div class="row g-5 py-5">
            <div class="col-12 text-center">
                <h1 class="text-white animated zoomIn">Our Team</h1>
                <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Team</li>
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
                    <img id="team_image" class="img-fluid rounded w-100" src="{{asset('Frontend/img/TeamMember')}}/{{$v->image}}" alt="{{$v->member_name}}">
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
