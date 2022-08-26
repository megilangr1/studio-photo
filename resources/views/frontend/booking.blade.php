@extends('frontend.layouts.master') 

@section('css')
<style>
	.form-group {
		padding: 10px 0px !important;
	}

	.form-group label {
		padding: 5px !important;
	}
</style>
@endsection

@section('content')
<hr>

<main id="main">
  <div class="row">
    <div class="col-12">
      <h5 class="text-center">Reservasi Studio</h5>
      <hr>
    </div>
    <div class="col-12 px-4">
      <div class="row">
        <div class="col-md-1">&ensp;</div>
        <div class="col-md-10">
          @if (Auth::user() && Auth::user()->email_verified_at == null)
            <div class="alert alert-info">
              Silahkan Lakukan Konfirmasi E-Mail Terlebih Dulu Untuk Melakukan Reservasi / Booking.
            </div>
          @else 
            @livewire('booking.main-form', ['mode' => 'frontend', 'paket' => $_GET['paket'] ?? null])
          @endif
        </div>
        <div class="col-md-1">&ensp;</div>
      </div>
    </div>
  </div>
</main>
@endsection