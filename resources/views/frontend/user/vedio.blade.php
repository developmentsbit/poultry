@extends('frontend.Layouts.master')
@section('body')
<div class="container-xxl py-5 bg-primary hero-header mb-5">
    <div class="container my-5 py-5 px-lg-5">
        <div class="row g-5 py-5">
            <div class="col-12 text-center">
                <h1 class="text-white animated zoomIn">Vedio Gallery</h1>
                <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a class="text-white" href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Vedio Gallery</li>
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
        <h2 class="mt-2">Watch Our Exclusive Vedios</h2>
    </div>
    <div class="row g-4">
        @if($data)
        @foreach ($data as $v)

        <div class="col-6 fadeInUp" data-wow-delay="0.1s">
            <div class="vedio-single">
                {!! $v->vedio_link !!}
                <b>{{$v->title}}</b>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
</div>
<!-- Team End -->
@endsection
