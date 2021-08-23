<!DOCTYPE html>
<html>
<head>
    <title>Hospital Information Management System</title>
    @include('includes.styles')
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="{{asset('/assets/css/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/owl.carousel.theme.default.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/nova.default.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
{{-- <body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body> --}}
<body>
<!-- navbar-->
<header class="header">
    <nav class="navbar navbar-expand-lg fixed-top bg-success">
      <div class="container"><a class="navbar-brand" href="#"><img src="https://theoptimist.news/wp-content/uploads/2019/09/DocsApp-logo.png" alt="" width="50"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-bars"></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link link-scroll active" href="#hero">Home <span class="sr-only">(current)</span></a></li>
            <li class="nav-item"><a class="nav-link link-scroll" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link link-scroll" href="#services">Services</a></li>
            <li class="nav-item"><a class="nav-link link-scroll" href="#testimonials">Testimonials</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <!-- Hero Section-->
  <section class="hero bg-top" id="hero" style="background: url({{ asset('assets/img/nova-template/banner1.png') }}) no-repeat; background-size: 100% 80%">
    <div class="container">
      <div class="row py-5">
        <div class="col-lg-5 py-5">
          <h1 class="font-weight-bold">Download your best app landing</h1>
          <p class="my-4 text-muted">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod.</p>
          <ul class="list-inline mb-0">
            <li class="list-inline-item mb-2 mb-lg-0"><a class="btn btn-primary btn-lg px-4" href="#"> <i class="fab fa-google-play mr-3"></i>Google Play</a></li>
            <li class="list-inline-item"><a class="btn btn-primary btn-lg px-4" href="#"> <i class="fab fa-app-store mr-3"></i>App Store</a></li>
          </ul>
        </div>
        <div class="col-lg  -6 ml-auto">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <section class="bg-center py-0" id="about" style="background: url(img/service-bg.d0e67e81.svg) no-repeat; background-size: cover">
    <section class="about py-0">
      <div class="container">
        <p class="h6 text-uppercase text-primary">Services</p>
        <h2 class="mb-5">Make your own success</h2>
        <div class="row pb-5">
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <!-- Services Item-->
            <div class="card border-0 shadow rounded-lg py-4 text-left">
              <div class="card-body p-5">
                <svg class="svg-icon svg-icon-light" style="width:60px;height:60px;color:#ff904e">
                  <use xlink:href="#document-saved-1"> </use>
                </svg>
                <h3 class="font-weight-normal h4 my-4">Online Marketing</h3>
                <p class="text-small mb-0">Lorem ipsum dolor amet consectetur adipisicing sed do eiusmod tempor incididunt ut labore.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
            <!-- Services Item-->
            <div class="card border-0 shadow rounded-lg py-4 text-left">
              <div class="card-body p-5">
                <svg class="svg-icon svg-icon-light" style="width:60px;height:60px;color:#39f8d2">
                  <use xlink:href="#map-marker-1"> </use>
                </svg>
                <h3 class="font-weight-normal h4 my-4">Track your move </h3>
                <p class="text-small mb-0">Lorem ipsum dolor amet consectetur adipisicing sed do eiusmod tempor incididunt ut labore.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6">
            <!-- Services Item-->
            <div class="card border-0 shadow rounded-lg py-4 text-left">
              <div class="card-body p-5">
                <svg class="svg-icon svg-icon-light" style="width:60px;height:60px;color:#8190ff">
                  <use xlink:href="#arrow-target-1"> </use>
                </svg>
                <h3 class="font-weight-normal h4 my-4">Market analysis</h3>
                <p class="text-small mb-0">Lorem ipsum dolor amet consectetur adipisicing sed do eiusmod tempor incididunt ut labore.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="with-pattern-1" id="services">
      <div class="container">
        <div class="row align-items-center mb-5">
          <div class="col-lg-6 mb-5 mb-lg-0"><img class="img-fluid w-100 px-lg-5" src="img/objects.e4497cfa.svg" alt=""></div>
          <div class="col-lg-6">
            <h2>The Best Business Solutions Guide for You</h2>
            <p class="text-muted">Dolor sit amet consectetur elit sed do eiusmod tempor incididunt labore dolore magna aliqua enim ad minim veniam quis nostrud exercitation.</p>
            <button class="btn btn-primary js-modal-btn" data-video-id="B6uuIHpFkuo"><i class="fas fa-play-circle mr-2"></i>Play video</button>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <h2>Make your own success as simple you clap</h2>
            <p class="text-muted">Dolor sit amet consectetur elit sed do eiusmod tempor incididunt labore dolore magna aliqua enim ad minim veniam quis nostrud exercitation.</p>
            <ul class="list-check">
              <li class="text-muted mb-2">Various Analysis Options</li>
              <li class="text-muted mb-2">Page Load Details (time, size, number of requests)</li>
              <li class="text-muted mb-2">Waterfall, Video and Report History</li>
            </ul>
            <button class="btn btn-primary js-modal-btn" data-video-id="B6uuIHpFkuo"><i class="fas fa-play-circle mr-2"></i>Play video</button>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="col-lg-6 col-sm-6 mb-4">
                <!-- Services Item-->
                <div class="card border-0 shadow rounded-lg text-left px-2">
                  <div class="card-body px py-5">
                    <svg class="svg-icon" style="width:40px;height:40px;color:#ff904e">
                      <use xlink:href="#document-saved-1"> </use>
                    </svg>
                    <h3 class="h5 font-weight-normal h4 my-3">Online Marketing</h3>
                    <p class="text-small mb-0 text-muted">Lorem ipsum dolor amet consectetur adipisicing.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 mb-4">
                <!-- Services Item-->
                <div class="card border-0 shadow rounded-lg text-left px-2">
                  <div class="card-body px py-5">
                    <svg class="svg-icon" style="width:40px;height:40px;color:#39f8d2">
                      <use xlink:href="#map-marker-1"> </use>
                    </svg>
                    <h3 class="h5 font-weight-normal h4 my-3">Track your move </h3>
                    <p class="text-small mb-0 text-muted">Lorem ipsum dolor amet consectetur adipisicing.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6 mb-4">
                <!-- Services Item-->
                <div class="card border-0 shadow rounded-lg text-left px-2">
                  <div class="card-body px py-5">
                    <svg class="svg-icon" style="width:40px;height:40px;color:#8190ff">
                      <use xlink:href="#arrow-target-1"> </use>
                    </svg>
                    <h3 class="h5 font-weight-normal h4 my-3">Market analysis</h3>
                    <p class="text-small mb-0 text-muted">Lorem ipsum dolor amet consectetur adipisicing.</p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-sm-6">
                <!-- Services Item-->
                <div class="card border-0 shadow rounded-lg text-left px-2">
                  <div class="card-body px py-5">
                    <svg class="svg-icon" style="width:40px;height:40px;color:#ff634b">
                      <use xlink:href="#sorting-1"> </use>
                    </svg>
                    <h3 class="h5 font-weight-normal h4 my-3">Full Settings</h3>
                    <p class="text-small mb-0 text-muted">Lorem ipsum dolor amet consectetur adipisicing.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
  <section class="p-0" id="testimonials" style="background: url(img/testimonials-bg.cc4a8da7.png) no-repeat; background-size: 40% 100%; background-position: left center">
    <div class="container text-center">
      <p class="h6 text-uppercase text-primary">Testimonials</p>
      <h2 class="mb-5">What Our Clients Says?</h2>
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="owl-carousel owl-theme testimonials-slider">
            <div class="mx-3 mx-lg-5 my-5 pt-3">
              <div class="card shadow rounded-lg px-4 py-5 px-lg-5 with-pattern bg-white border-0">
                <div class="card-body index-forward pt-5 rounded-lg">
                  <div class="testimonial-img"><img class="rounded-circle" src="img/avatar-1.a288a8c1.jpg" alt=""/></div>
                  <p class="lead text-muted mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                  <h5 class="font-weight-bold mb-0">Sarah Hudson</h5>
                  <p class="text-primary mb-0 text-small">Tech Developer</p>
                </div>
              </div>
            </div>
            <div class="mx-3 mx-lg-5 my-5 pt-3">
              <div class="card shadow rounded-lg px-4 py-5 px-lg-5 with-pattern bg-white border-0">
                <div class="card-body index-forward pt-5 rounded-lg">
                  <div class="testimonial-img"><img class="rounded-circle" src="img/avatar-2.0af75238.png" alt=""/></div>
                  <p class="lead text-muted mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                  <h5 class="font-weight-bold mb-0">Frank Smith</h5>
                  <p class="text-primary mb-0 text-small">Tech Developer</p>
                </div>
              </div>
            </div>
            <div class="mx-3 mx-lg-5 my-5 pt-3">
              <div class="card shadow rounded-lg px-4 py-5 px-lg-5 with-pattern bg-white border-0">
                <div class="card-body index-forward pt-5 rounded-lg">
                  <div class="testimonial-img"><img class="rounded-circle" src="img/avatar-1.a288a8c1.jpg" alt=""/></div>
                  <p class="lead text-muted mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                  <h5 class="font-weight-bold mb-0">Sarah Hudson</h5>
                  <p class="text-primary mb-0 text-small">Tech Developer</p>
                </div>
              </div>
            </div>
            <div class="mx-3 mx-lg-5 my-5 pt-3">
              <div class="card shadow rounded-lg px-4 py-5 px-lg-5 with-pattern bg-white border-0">
                <div class="card-body index-forward pt-5 rounded-lg">
                  <div class="testimonial-img"><img class="rounded-circle" src="img/avatar-2.0af75238.png" alt=""/></div>
                  <p class="lead text-muted mb-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                  <h5 class="font-weight-bold mb-0">Frank Smith</h5>
                  <p class="text-primary mb-0 text-small">Tech Developer</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><a class="scropll-top-btn" id="scrollTop" href="#"><i class="fas fa-long-arrow-alt-up"></i></a>
  <footer class="with-pattern-1 position-relative">
    <div class="container section-padding-y">
      <div class="row">
        <div class="col-lg-3 mb-4 mb-lg-0"><img class="mb-4" src="img/logo.6dbc2852.svg" alt="" width="110">
          <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
        </div>
        <div class="col-lg-2 mb-4 mb-lg-0">
          <h2 class="h5 mb-4">Quick Links</h2>
          <div class="d-flex">
            <ul class="list-unstyled d-inline-block mr-4 mb-0">
              <li class="mb-2"><a class="footer-link" href="#">History </a></li>
              <li class="mb-2"><a class="footer-link" href="#">About us</a></li>
              <li class="mb-2"><a class="footer-link" href="#">Contact us</a></li>
              <li class="mb-2"><a class="footer-link" href="#">Services</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 mb-4 mb-lg-0">
          <h2 class="h5 mb-4">Services</h2>
          <div class="d-flex">
            <ul class="list-unstyled mr-4 mb-0">
              <li class="mb-2"><a class="footer-link" href="#">History </a></li>
              <li class="mb-2"><a class="footer-link" href="#">About us</a></li>
              <li class="mb-2"><a class="footer-link" href="#">Contact us</a></li>
              <li class="mb-2"><a class="footer-link" href="#">Services</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-5">
          <h2 class="h5 mb-4">Contact Info</h2>
          <ul class="list-unstyled mr-4 mb-3">
            <li class="mb-2 text-muted">728  Ocello Street, San Diego, California. </li>
            <li class="mb-2"><a class="footer-link" href="tel:619-851-4132">619-851-4132</a></li>
            <li class="mb-2"><a class="footer-link" href="mailto:Nova@example.com">Nova@example.com</a></li>
          </ul>
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-twitter"></i></a></li>
            <li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-google-plus"></i></a></li>
            <li class="list-inline-item"><a class="social-link" href="#"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="copyrights">       
      <div class="container text-center py-4">
        <p class="mb-0 text-muted text-sm">&copy; 2019, Your company. Template by <a href="https://bootstraptemple.com" class="text-reset">Bootstrap Temple</a>.</p>
      </div>
    </div>
  </footer>
</body>
@include('includes.scripts')
<script src="{{asset('/assets/js/plugins/owl.carousel.min.js')}}"></script>
<script src="{{asset('/assets/js/plugins/nova.default.js')}}"></script>
<script>

var stylesheet = $('link#theme-stylesheet');
$("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
var alternateColour = $('link#new-stylesheet');

if ($.cookie("theme_csspath")) {
    alternateColour.attr("href", $.cookie("theme_csspath"));
}

$("#colour").change(function () {

    if ($(this).val() !== '') {

        var theme_csspath = $(this).val();

        alternateColour.attr("href", theme_csspath);

        $.cookie("theme_csspath", theme_csspath, {
            expires: 365,
            path: document.URL.substr(0, document.URL.lastIndexOf('/'))
        });

    }

    return false;
});
</script>
</html>