@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Edit Data Pelanggan</h5>
        <div class="card-tools">
          <a href="{{ route('backend.pelanggan.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.pelanggan.update', $pelanggan->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="name">Nama Pelanggan :</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pelanggan..." value="{{ $pelanggan->nama_lengkap }}" required autofocus>
                <div class="invalid-feedback">
                  {{ $errors->first('nama_lengkap') }}
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="email">E-Mail Pelanggan :</label>
                <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Masukan E-Mail Pelanggan..." value="{{ $pelanggan->user->email }}" required>
                <div class="invalid-feedback">
                  {{ $errors->first('email') }}
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nomor_hp">Nomor Hp :</label>
                <input type="text" name="nomor_hp" id="nomor_hp" class="form-control {{ $errors->has('nomor_hp') ? 'is-invalid':'' }}" placeholder="Masukan E-Mail Pelanggan..." value="{{ $pelanggan->nomor_hp }}" required>
                <div class="invalid-feedback">
                  {{ $errors->first('nomor_hp') }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Password : </label>
                <div class="float-right text-xs font-weight-bold text-secondary">* Isi Apabila Ingin Merubah Password</div>
                <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukan Password...">
                <div class="invalid-feedback">
                  {{ $errors->first('password') }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password_confirmation">Tulis Ulang Password :</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Silahkan Tulis Ulang Password...">
              </div>
            </div>
            <div class="col-12">
              <hr class="my-2">
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block">
                <span class="fa fa-check"></span> &ensp; Buat Data
              </button>
            </div>
            <div class="col-md-4">
              <button type="reset" class="btn btn-danger btn-block">
                <span class="fa fa-undo"></span> &ensp; Reset Input
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection