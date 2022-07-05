@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Buat Data Kategori</h5>
        <div class="card-tools">
          <a href="{{ route('backend.kategori.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.kategori.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="nama_kategori">Nama Kategori : </label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control {{ $errors->has('nama_kategori') ? 'is-invalid':'' }}" value="{{ old('nama_kategori') }}" placeholder="Masukan Nama Kategori..." required autofocus>
                <span class="invalid-feedback">
                  {{ $errors->first('nama_kategori') }}
                </span>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="keterangan">Keterangan Lainnya : </label>
                <textarea name="keterangan" id="keterangan" cols="1" rows="1" class="form-control {{ $errors->has('keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Kategori">{{ old('keterangan') }}</textarea>
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block">
                <span class="fa fa-check"></span> &ensp; Tambah Data Kategori
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection