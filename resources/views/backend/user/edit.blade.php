@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Edit Data Pengguna</h5>
        <div class="card-tools">
          <a href="{{ route('backend.user.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.user.update', $user->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label for="name">Nama Pengguna :</label>
                <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pengguna..." value="{{ $user->name }}" required autofocus>
                <div class="invalid-feedback">
                  {{ $errors->first('name') }}
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="email">E-Mail Pengguna :</label>
                <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" placeholder="Masukan E-Mail Pengguna..." value="{{ $user->email }}" required>
                <div class="invalid-feedback">
                  {{ $errors->first('email') }}
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