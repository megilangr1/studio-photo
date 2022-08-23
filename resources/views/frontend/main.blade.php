@extends('frontend.layouts.master')

@section('content')
<section id="hero" class="d-flex flex-column justify-content-center align-items-center">
  <div class="container" data-aos="fade-in">
    <h1>Welcome to Afternoon Project </h1>
    <h2>We are team of talented designers making websites with Bootstrap</h2>
    <div class="d-flex align-items-center">
    </div>
  </div>
</section>

<main id="main">
  <hr><hr><hr><hr><hr>

  <section id="paket" class="paket">
    <div class="container">

      <div class="section-title">
        <p data-aos="fade-up"><hr></p>
        <h2 data-aos="fade-up">Daftar Paket Afternoon Project Studio</h2>
        <p data-aos="fade-up"><hr></p>
      </div>

      {{-- <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="portfolio-flters">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">Keluarga</li>
            <li data-filter=".filter-card">Wisuda</li>
            <li data-filter=".filter-web">Prewed</li>
          </ul>
        </div>
      </div> --}}

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
        @forelse ($pakets as $item)
          <a href="{{ route('paket', $item->id) }}">
            <div class="col-lg-4 col-md-6 portfolio-item filter-app text-center p-3">
              <img src="{{ $item->file_paket != null ? asset($item->file_path) : asset('frontend/img/portfolio/portfolio-1.jpg') }}" class="img-fluid" alt="" style="width: 250px !important; height: 250px !important;">
              <div class="portfolio-info py-2">
                <h4 style="color: #565656;">{{ $item->nama_paket }}</h4>
                <p style="color: #565656;">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                {{-- <a href="{{ asset('frontend') }}/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a> --}}
                {{-- <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> --}}
              </div>
            </div>
          </a>
        @empty
          <div class="col-12 text-center">
            <h5>Belum Ada Paket Foto.</h5>
          </div>
        @endforelse

      </div>

    </div>
  </section>

</main>
@endsection