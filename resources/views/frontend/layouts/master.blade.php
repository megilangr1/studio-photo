<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Afternoon Project</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('frontend') }}/img/favicon.png" rel="icon">
    <link href="{{ asset('frontend') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend') }}/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ asset('frontend') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend') }}/css/style.css" rel="stylesheet">
    <style>
      .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #2a2a2a !important;
        border: 1px solid #aaa !important;
        padding-left: 5px;
        padding-right: 5px;
      }
      .select2-container .select2-selection--single {
        height: 38px !important;
      }
      .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px !important;
      }
  
      .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
      }
      
    </style>
    

    @livewireStyles
    @yield('css')
    @stack('css')
    <!-- =======================================================
    * Template Name: Flexor - v4.7.0
    * Template URL: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
  </head>
  <body>

    <!-- ======= Top Bar ======= -->
    <section id="topbar" class="d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">

        <div class="cta d-none d-md-flex align-items-center">
          @if (auth()->user())
            <a href="{{ in_array('Administrator', auth()->user()->getRoleNames()->toArray()) ? route('backend.main') : '#' }}" class="scrollto">Hi, {{ auth()->user()->name }}</a>
            <a class="scrollto" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          @else
            <a href="{{ route('login') }}" class="scrollto mx-1">Login</a>
            <a href="{{ route('register') }}" class="scrollto mx-1">Register</a>
          @endif
        </div>
      </div>
    </section>
    @if (auth()->user() && auth()->user()->email_verified_at == null)
      <section id="topbar" class="d-flex align-items-center" style="height: auto !important;">
        <div class="container">
          <div class="d-flex" style="font-size: 12px !important; padding: 3px 0px;">
            Akun Belum Melakukan Verifikasi E-Mail. Silahkan Lakukan Verifikasi E-Mail Terlebih Dahulu. &ensp; <a href="#" onclick="document.getElementById('resend').submit()"> Kirim Ulang Link </a>
          </div>
          <form action="{{ route('resend') }}" method="post" id="resend">
            @csrf
          </form>
        </div>
      </section>
    @endif

    @if (session()->has('resend-verify'))
    <section id="topbar" class="d-flex align-items-center" style="height: auto !important;">
      <div class="container">
        <div class="d-flex" style="font-size: 10px !important;">
          Link Konfirmasi Email Berhasil di-Kirim Ulang. Silahkan Cek Email Anda !
        </div>
      </div>
    </section>
    @endif

    
    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
          <h1><a href="{{ route('frontend') }}">AFTRNOON PROJECT STUDIO</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html"><img src="{{ asset('frontend') }}/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar">
          <ul>
            <li><a class="nav-link scrollto active" href="#hero"></a></li>
            <li><a class="nav-link scrollto " href="{{ route('frontend') }}#paket">Paket</a></li>
            <li><a class="nav-link scrollto" href="{{ route('booking') }}">Booking</a></li>
            <li><a class="nav-link scrollto" href="{{ route('data-booking') }}">Data Reservasi</a></li>
            <li><a class="nav-link scrollto" href="{{ route('faq') }}">FAQ</a></li>
            {{-- <li class="dropdown"><a href="#"><span>Keuangan</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="#">Kas Masuk</a></li>
                <li class="dropdown"><a href="#"><span>Kas Keluar</span> <i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">Pembelian</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a class="nav-link scrollto" href="#contact">Properti</a></li> --}}
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div>
    </header><!-- End Header -->

    @yield('content')
    
    <!-- ======= Footer ======= -->
    <footer>
      <div class="container d-lg-flex py-4">

        <div class="me-lg-auto text-center text-lg-start">
          <div class="copyright" >
            &copy; Copyright <strong><span>Safira</span></strong>.<!--All Rights Reserved-->
          </div>
          <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/flexor-free-multipurpose-bootstrap-template/ 
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
          </div>
        </div>
        <div class="social-links text-center text-lg-right pt-3 pt-lg-0">
          <a href="https://api.whatsapp.com/send/?phone=628992245000&text=Hallo+Afternoon%2C+pengen+tanya+tanya+buat+foto+dong+kak%3A%29&app_absent=0" class="WhatsApp"><i class="bi bi-phone d-flex align-items ms-4"></i></a>
          <a href="https://www.facebook.com/afternoonproject" class="facebook"><i class="bx bxl-facebook"></i></a>
          <a href="https://www.bing.com/search?q=afternoon+studio+bandung&cvid=a5fdc5bc48df413f8cc992f6ce23179b&aqs=edge.0.69i59j0l3j69i57j0l2j69i61j69i60.1860j0j1&pglt=43&FORM=ANNTA1&PC=U531" class="instagram"><i class="bx bxl-instagram"></i></a>
          <!-- <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
          <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a> -->
        </div>
      </div>
    </footer>

    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontend') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/php-email-form/validate.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('frontend') }}/js/main.js"></script>

    @livewireScripts

    @yield('script')
    @stack('script')

  </body>
</html>