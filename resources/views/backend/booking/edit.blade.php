@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-boxes text-primary"></span> &ensp; Detail Data Booking / Reservasi Pemotretan</h5>
        <div class="card-tools">
          <a href="{{ route('backend.booking.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        {{-- <form action="{{ route('backend.booking.store') }}" method="post">
          @csrf 
        </form> --}}
        @livewire('booking.detail-form', ['mode' => 'backend', 'booking' => $booking->toArray()])
      </div>
    </div>
  </div>
</div>
@endsection