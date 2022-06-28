@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Edit Data Paket</h5>
        <div class="card-tools">
          <a href="{{ route('backend.paket.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        @livewire('paket.main-form', ['paket' => $paket->toArray()])
      </div>
    </div>
  </div>
</div>
@endsection