@extends('frontend.layouts.master') 

@section('content')
<hr>

<main id="main">
  <div class="row">
    <div class="col-12">
      <h5 class="text-center">Login Studio Foto</h5>
      <hr>
    </div>
    <div class="col-12 px-4">
      <div class="row">
        <div class="col-md-3">&ensp;</div>
        <div class="col-md-6">
          <form action="{{ route('login-process') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group py-2">
                  <label for="email" class="py-2">E-Mail :</label>
                  <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" value="{{ old('email') }}" placeholder="Masukan E-Mail..." required autofocus>
                  <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group py-2">
                  <label for="password" class="py-2">Password :</label>
                  <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukan Password..." required>
                  <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                  </div>
                </div>
              </div>
              <div class="col-md-12 py-2">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-warning my-2">
                    Login Studio Photo
                  </button>
                </div>
                
                @if (count($errors) > 0 || session()->has('error-login'))
                  <div class="alert alert-warning text-center">
                    Username / Password Salah !
                  </div>
                @endif

                @if (session()->has('verified'))
                  <div class="alert alert-success text-center">
                    E-Mail Berhasil di-Verifikasi !
                  </div>
                @endif

                @if (session()->has('must-verify'))
                  <div class="alert alert-info text-center">
                    Silahkan Cek E-Mail Anda Untuk Melakukan Konfirmasi Akun !
                  </div>
                @endif
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-3">&ensp;</div>
      </div>
    </div>
  </div>
</main>
@endsection