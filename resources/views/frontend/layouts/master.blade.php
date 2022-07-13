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

    <!-- Template Main CSS File -->
    <link href="{{ asset('frontend') }}/css/style.css" rel="stylesheet">

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
            <li><a class="nav-link scrollto" href="#booking">Booking</a></li>
            <li><a class="nav-link scrollto" href="#pricing">Pesanan</a></li>
            <li><a class="nav-link scrollto" href="#pricing">Pembayaran</a></li>
            <li><a class="nav-link scrollto" href="#pricing">Hasil Foto</a></li>
            <li class="dropdown"><a href="#"><span>Keuangan</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <li><a href="#">Kas Masuk</a></li>
                <li class="dropdown"><a href="#"><span>Kas Keluar</span> <i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <li><a href="#">Pembelian</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a class="nav-link scrollto" href="#contact">Properti</a></li>
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

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontend') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend') }}/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('frontend') }}/js/main.js"></script>

  </body>
</html>