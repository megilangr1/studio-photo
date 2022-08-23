<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env('APP_NAME') }}</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/toastr/toastr.min.css">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{ asset('assets') }}/plugins/ekko-lightbox/ekko-lightbox.css">
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

    
  </style>
  @livewireStyles

  <style>
    .borad {
      border-radius: 0px !important;
    }
  </style>
  @yield('css')
  @stack('css')

</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">{{ env('APP_NAME') }}</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        {{-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="{{ asset('assets') }}/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="{{ asset('assets') }}/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <div class="media">
                <img src="{{ asset('assets') }}/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li> --}}
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="{{ asset('assets') }}/index3.html" class="brand-link">
        <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME_SHORT') }}</span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ asset('assets') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ auth()->user()->name }}</a> 
          </div>
        </div>
        <div class="user-panel mt-3 pb-3 mb-3 px-2 text-center">
          <a class="btn btn-danger btn-xs btn-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout Sistem
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </div>
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ route('backend.main') }}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Halaman Utama</p>
              </a>
            </li>
            <li class="nav-item ">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  Master Data
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if (in_array("Data Pengguna", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.user.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pengguna</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Data Pelanggan", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.pelanggan.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Data Pelanggan</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Data Paket", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.paket.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Daftar Paket</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Data Studio", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.studio.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Daftar Studio</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Data Kategori Properti", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.kategori.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Kategori Properti</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Data Properti", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.properti.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Daftar Properti</p>
                    </a>
                  </li>
                @endif
              </ul>
            </li>
            <li class="nav-item ">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-minus-square"></i>
                <p>
                  Transaksi
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @if (in_array("Transaksi Pembelian Properti", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.pembelian.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pembelian Properti</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Transaksi Booking", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.booking.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Booking / Pemesanan</p>
                    </a>
                  </li>
                @endif
                @if (in_array("Transaksi Pencatatan Kas", auth()->user()->permissions()->pluck('name')->toArray()))
                  <li class="nav-item">
                    <a href="{{ route('backend.kas.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Pencatatan Kas</p>
                    </a>
                  </li>
                @endif
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <section class="content pt-2">
        @yield('content')
      </section>
    </div>

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.2.0
      </div>
      <strong>Copyright &copy; 2022 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
    </aside>
  </div>
</body>
<script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets') }}/dist/js/adminlte.min.js"></script>

<!-- Select2 -->
<script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>
<!-- Toastr -->
<script src="{{ asset('assets') }}/plugins/toastr/toastr.min.js"></script>
<!-- Ekko Lightbox -->
<script src="{{ asset('assets') }}/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
@livewireScripts

<script>
  $(document).ready(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });
  });
</script>

@if (session()->has('success'))
  <script>
    toastr.success("{!! session('success') !!}", "Berhasil", {timeOut: 10000});
  </script>
@endif

@if (session()->has('info'))
  <script>
    toastr.info("{!! session('info') !!}", "Pemberitahuan", {timeOut: 10000});
  </script>
@endif

@if (session()->has('warning'))
  <script>
    toastr.warning("{!! session('warning') !!}", "Peringatan", {timeOut: 10000});
  </script>
@endif

@if (session()->has('error'))
  <script>
    toastr.error("{!! session('error') !!}", "Kesalahan", {timeOut: 10000});
  </script>
@endif

<script>
  Livewire.on('success', data => {
    toastr.success(data, "Berhasil");
  });

  Livewire.on('info', data => {
    toastr.info(data, "Pemberitahuan");
  });

  Livewire.on('warning', data => {
    toastr.warning(data, "Peringatan !");
  });

  Livewire.on('error', data => {
    toastr.error(data, "Kesalahan !!");
  });
</script>

@yield('script')
@stack('script')
</body>
</html>
