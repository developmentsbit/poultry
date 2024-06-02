@extends('Frontend.Layouts.master')
@section('body')
<div class=" py-5">
    <div class="mt-5">

        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if($slider)
                @foreach ($slider as $v)
                <div class="carousel-item @if($v->index_no == 1) active @endif">
                  <img src="{{asset('Frontend/img/PhotoGallery')}}/{{$v->image}}" class="d-block w-100" alt="{{$v->title}}">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{{$v->title}}</h5>
                    <p>{!! $v->description !!}</p>
                  </div>
                </div>
                @endforeach
                @endif
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
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
            <p class="mb-4" style="text-align: justify">{!! $about_us->description !!}</p>
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
        {{-- <div class="col-lg-6">
            <img id="about_us_image" class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{asset('Frontend/img/about_us')}}/{{$about_us->image}}">
        </div> --}}
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
            <img class="img-fluid mt-5" style="height: 250px;" src="{{asset('Frontend')}}/img/newsletter.png">
        </div>
    </div>
</div>
</div>
<!-- Newsletter End -->


<!-- Service Start -->
<div class="container-xxl py-5">
<div class="container px-lg-5">
    <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="position-relative d-inline text-primary ps-4">Our Services</h6>
        <h2 class="mt-2">What Service We Provide</h2>
    </div>
    <div class="row g-4">
        @if($service)
        @foreach ($service as $v)
        <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
            <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                <div class="service-image">
                    <img src="{{asset('Frontend/img/ServiceImage')}}/{{$v->image}}" alt="{{$v->title}}" class="img-fluid">
                </div>
                <h5 class="mb-3">{{$v->title}}</h5>

                <a class="btn px-3 mt-auto mx-auto" href="{{url('service_detail')}}/{{$v->id}}">Read More</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
</div>
<!-- Service End -->


<!-- Portfolio Start -->
<div class="container-xxl py-5">
<div class="container px-lg-5">
    <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="position-relative d-inline text-primary ps-4">Our Projects</h6>
        <h2 class="mt-2">Our Projects</h2>
    </div>
    <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
        <div class="col-12 text-center">
            <ul class="list-inline mb-5" id="portfolio-flters">
                <li class="btn px-3 pe-4 active" data-filter="*">All</li>
                @if($project_cat)
                @foreach($project_cat as $v)
                <li class="btn px-3 pe-4" data-filter=".{{$v->id}}">{{$v->categorey_name}}</li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="row g-4 portfolio-container">
        @if($project_info)
        @foreach ($project_info as $v)
        <div class="col-lg-4 col-md-6 portfolio-item {{$v->project_cat}} wow zoomIn" data-wow-delay="0.1s">
            <div class="position-relative rounded overflow-hidden">
                <img class="img-fluid w-100" src="{{asset('Frontend/img/ProjectImage')}}/{{$v->image}}" alt="{{$v->project_name}}" id="project_pc">
                <div class="portfolio-overlay">
                    <a class="btn btn-light" href="{{asset('Frontend/img/ProjectImage')}}/{{$v->image}}" data-lightbox="portfolio"><i class="fa fa-plus fa-2x text-primary"></i></a>
                    <div class="mt-auto">
                        <small class="text-white"><i class="fa fa-folder me-2"></i>{{$v->company_name}}</small>
                        <a class="h5 d-block text-white mt-1 mb-0" href="{{url('/project_details')}}/{{$v->id}}">{{$v->project_name}}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>
</div>
</div>
<!-- Portfolio End -->

<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container px-lg-5">
        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="position-relative d-inline text-primary ps-4">Our Team</h6>
            <h2 class="mt-2">Watch Our Exclusive Vedios</h2>
        </div>
        <div class="row g-4">
            @if($vedio)
            @foreach ($vedio as $v)

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


<!-- Testimonial Start -->
<div class="container-xxl bg-primary testimonial py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
<div class="container py-5 px-lg-5">
    <div class="owl-carousel testimonial-carousel">
        @if($testimonial)
        @foreach ($testimonial as $v)

        <div class="testimonial-item bg-transparent border rounded text-white p-4">
            <i class="fa fa-quote-left fa-2x mb-3"></i>
            <p>{!! $v->description !!}</p>
            <div class="d-flex align-items-center">
                <img class="img-fluid flex-shrink-0 rounded-circle" src="{{asset('Frontend/img/Testimonial')}}/{{$v->image}}" style="width: 50px; height: 50px;">
                <div class="ps-3">
                    <h6 class="text-white mb-1">{{$v->client_name}}</h6>
                    <small>{{$v->client_profession}}</small><br>
                    <small>{{$v->client_company}}</small>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
</div>
<!-- Testimonial End -->


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


<!-- Photo Gallery -->
<div class="container-xxl py-5">
<div class="container px-lg-5">
    <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
        <h6 class="position-relative d-inline text-primary ps-4">Photo Gallery</h6>
        <h2 class="mt-2"></h2>
    </div>
    <div uk-slider>

        <div class="uk-position-relative">

            <div class="uk-slider-container uk-light">
                <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                    @if($gallery)
                    @foreach ($gallery as $v)
                    <li style="margin-left:10px;margin-right:10px;">
                        <img src="{{asset('Frontend/img/PhotoGallery')}}/{{$v->image}}" width="400" height="600" alt="">
                        <div style="background:linear-gradient(4deg, #4c4949, transparent)" class="uk-position-bottom uk-panel text-center"><h5>{{$v->title}}</h5></div>
                    </li>
                    @endforeach
                    @endif

                </ul>
            </div>

            <div class="uk-hidden@s uk-light">
                <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>

            <div class="uk-visible@s">
                <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>

        </div>

        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

    </div>
</div>
</div>
<!-- Photo Gallery -->
@endsection


