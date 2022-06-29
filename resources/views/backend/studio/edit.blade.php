@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Edit Data Studio</h5>
        <div class="card-tools">
          <a href="{{ route('backend.studio.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.studio.update', $studio->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="nama_studio">Nama Studio : </label>
                <input type="text" name="nama_studio" id="nama_studio" class="form-control {{ $errors->has('nama_studio') ? 'is-invalid':'' }}" value="{{ $studio->nama_studio }}" placeholder="Masukan Nama Studio..." required autofocus>
                <span class="invalid-feedback">
                  {{ $errors->first('nama_studio') }}
                </span>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="keterangan_studio">Keterangan Lainnya Studio : </label>
                <textarea name="keterangan_studio" id="keterangan_studio" cols="1" rows="1" class="form-control {{ $errors->has('keterangan_studio') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Studio">{{ $studio->keterangan_studio }}</textarea>
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block">
                <span class="fa fa-check"></span> &ensp; Tambah Data Studio
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection