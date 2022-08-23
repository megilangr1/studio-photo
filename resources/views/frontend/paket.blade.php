@extends('frontend.layouts.master')

@section('content')
<main id="main">
  <section id="paket" class="paket" style="padding: 30px !important;">
    <div class="container">

      <div class="section-title">
        <p data-aos="fade-up"><hr></p>
        <h2 data-aos="fade-up">Paket Foto {{ $paket->nama_paket }}</h2>
        <p data-aos="fade-up"><hr></p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-md-4 d-flex justify-content-center">
          <img src="{{ $paket->file_paket != null ? asset($paket->file_path) : asset('frontend/img/portfolio/portfolio-1.jpg') }}" class="img-fluid" alt="" style="width: 250px !important; height: 250px !important;">
        </div>
        <div class="col-md-8">
          <h6>Harga Paket : Rp. {{ number_format($paket->harga, 0, ',' ,'.') }}</h6>
          <h6>Jumlah Berfoto : {{ $paket->jumlah_foto }} Foto</h6>
          <h6>Durasi Pemotretan : {{ $paket->durasi }} Menit</h6>
          <h6>Jumlah Baju : {{ $paket->jumlah_baju }} Baju</h6>
          <h6>Pose : {{ $paket->pose }} Pose</h6>
          <h6>Harga Tambah Berfoto : {{ $paket->harga_tambah_foto }} / Foto</h6>
          <h6>Informasi Tambahan : {{ $paket->informasi_tambahan ?? 'Tidak Ada Informasi Tambahan'}}</h6>

          <br>
          <a href="{{ route('booking') }}?paket={{ $paket->id }}" class="btn btn-warning">
            Buat Reservasi Paket
          </a>
        </div>
      </div>
    </div>
  </section>

</main>
@endsection