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
      <h5 class="text-center">Hasil Foto | {{ $booking->kode_booking }}</h5>
      <hr>
    </div>
    <div class="col-12 px-4">
      <div class="row px-4">
        @forelse ($booking->hasilFoto as $item)
          <div class="col-md-2 py-2 align-middle text-center">
            <a href="{{ asset($item->file_path) }}" target="_blank">
              <img src="{{ asset($item->file_path) }}" alt="" srcset="" class="img-fluid">
            </a>
          </div>
        @empty
          <div class="col-md-12">
            Belum Ada Hasil Foto.
          </div>
        @endforelse
      </div>
    </div>
  </div>
</main>

@endsection

@section('script')
@endsection