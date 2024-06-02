<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$wb_content->title}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="{{asset('Frontend')}}/img/{{$wb_content->favicon}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('Frontend')}}/lib/animate/animate.min.css" rel="stylesheet">
    <link href="{{asset('Frontend')}}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="{{asset('Frontend')}}/lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('Frontend')}}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('Frontend')}}/css/style.css" rel="stylesheet">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.10/dist/css/uikit.min.css" />
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0 bg-primary">
                <a href="{{url('/')}}" class="navbar-brand p-0">

                    <img src="{{asset('Frontend')}}/img/{{$wb_content->logo}}" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{url('/')}}" class="nav-item nav-link {{request()->Is('/') ? 'active' : ''}}">Home</a>
                        <a href="{{url('about-us')}}" class="nav-item nav-link {{request()->Is('about-us') ? 'active' : ''}}">About</a>
                        <a href="{{url('/service')}}" class="nav-item nav-link {{request()->Is('service') ? 'active' : ''}}">Service</a>
                        <a href="{{url('/project')}}" class="nav-item nav-link {{request()->Is('project') ? 'active' : ''}}">Project</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle {{request()->Is('our_team') ? 'active' : ''}} {{request()->Is('testimonials') ? 'active' : ''}}" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0">
                                <a href="{{url('our_team')}}" class="dropdown-item {{request()->Is('our_team') ? 'active' : ''}}">Our Team</a>
                                <a href="{{url('testimonials')}}" class="dropdown-item {{request()->Is('testimonials') ? 'active' : ''}}">Testimonial</a>
                                <a href="{{url('vedio')}}" class="dropdown-item {{request()->Is('vedio') ? 'active' : ''}}">Vedio Gallery</a>
                            </div>
                        </div>
                        <a href="{{url('contact')}}" class="nav-item nav-link {{request()->Is('contact') ? 'active' : ''}}">Contact</a>
                    </div>
                    <butaton type="button" class="btn text-secondary ms-3" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fa fa-search"></i></butaton>
                </div>
            </nav>

@yield('body')


        <!-- Footer Start -->
        <div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-5">
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p><i class="fa fa-map-marker-alt me-3"></i>{{$wb_content->adress}}</p>
                        <p><i class="fa fa-phone-alt me-3"></i>{{$wb_content->phone1}}</p>
                        <p><i class="fa fa-envelope me-3"></i>{{$wb_content->email}}</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href="{{$wb_content->twiiter}}"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href="{{$wb_content->facebook}}"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href="{{$wb_content->youtube}}"><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href="{{$wb_content->instagram}}"><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-light btn-social" href="{{$wb_content->linkedin}}"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Popular Link</h5>
                        <a class="btn btn-link" href="{{url('/about-us')}}">About Us</a>
                        <a class="btn btn-link" href="{{url('/contact')}}">Contact Us</a>
                        <a class="btn btn-link" href="{{url('/service')}}">Services</a>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <h5 class="text-white mb-4">Newsletter</h5>
                        <p>Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit non vulpu</p>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; All Right Reserved.

							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://sbit.com.bd">Skill Based IT - SBIT</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/wow/wow.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/easing/easing.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/waypoints/waypoints.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/isotope/isotope.pkgd.min.js"></script>
    <script src="{{asset('Frontend')}}/lib/lightbox/js/lightbox.min.js"></script>

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.10/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.10/dist/js/uikit-icons.min.js"></script>

    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

    <!-- Template Javascript -->
    <script src="{{asset('Frontend')}}/js/main.js"></script>


    <script>

        $("#loading").hide();

    $('#form-data').submit(function(e){

        e.preventDefault();

        $('#name').on('keyup',function(){
            $('#name').removeClass('is-invalid');
        });
        $('#email').on('keyup',function(){
            $('#email').removeClass('is-invalid');
        });
        $('#subject').on('keyup',function(){
            $('#subject').removeClass('is-invalid');
        });
        $('#message').on('keyup',function(){
            $('#message').removeClass('is-invalid');
        });

        var name = $('#name').val();

        var email = $('#email').val();

        var subject = $('#subject').val();

        var message = $('#message').val();

        if(name == "")
        {
            $('#name').addClass('is-invalid');
        }
        else if(email == "")
        {
            $('#email').addClass('is-invalid');
        }
        else if(subject == "")
        {
            $('#subject').addClass('is-invalid');
        }
        else if(message == "")
        {
            $('#message').addClass('is-invalid');
        }
        else
        {
            $.ajax({
                headers:{
                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                },
                url : '{{ url('sendMessage') }}',

                type : 'POST',

                data : new FormData(this),

                cache:false,

                contentType: false,

                processData: false,

                beforeSend : function()
                {
                    $('#loading').show();
                    $('#submit').hide();
                },
                success : function(data)
                {
                    if(data == 1)
                    {
                        toastr.success('Message sent successfully. You will recive a email from us', 'Success');
                        $('#loading').hide();
                        $('#submit').show();
                    }
                    else
                    {
                        toastr.success('Message sent Unsuccessfully.', 'Error');
                        $('#loading').hide();
                        $('#submit').show();

                    }

                }
            });
        }

    });
</script>
</body>

</html>
