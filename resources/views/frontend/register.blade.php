@extends('frontend.layouts.master') 

@section('content')
<hr>

<main id="main">
  <div class="row">
    <div class="col-12">
      <h5 class="text-center">Registrasi Pelanggan Studio Foto</h5>
      <hr>
    </div>
    <div class="col-12 px-4">
      <div class="row">
        <div class="col-md-3">&ensp;</div>
        <div class="col-md-6">
          <form action="{{ route('registration') }}" method="post">
            @csrf
            <div class="row">
              <div class="col-md-7">
                <div class="form-group py-2">
                  <label for="name" class="py-2">Nama Lengkap :</label>
                  <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" value="{{ old('name') }}" placeholder="Masukan Nama Lengkap..." required autofocus>
                  <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                  </div>
                </div>
              </div>
              <div class="col-md-5">
                <div class="form-group py-2">
                  <label for="nomor_hp" class="py-2">Nomor Hp : </label>
                  <input type="text" name="nomor_hp" id="nomor_hp" class="form-control {{ $errors->has('nomor_hp') ? 'is-invalid':'' }}" value="{{ old('nomor_hp') }}" placeholder="Masukan Nomor Hp..." required>
                  <div class="invalid-feedback">
                    {{ $errors->first('nomor_hp') }}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group py-2">
                  <label for="email" class="py-2">E-Mail :</label>
                  <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" value="{{ old('email') }}" placeholder="Masukan E-Mail..." required>
                  <div class="invalid-feedback">
                    {{ $errors->first('email') }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group py-2">
                  <label for="password" class="py-2">Password :</label>
                  <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" placeholder="Masukan Password..." required>
                  <div class="invalid-feedback">
                    {{ $errors->first('password') }}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group py-2">
                  <label for="password_confirmation" class="py-2">Konfirmasi Ulang Password :</label>
                  <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid':'' }}" placeholder="Masukan Ulang Password..." required>
                  <div class="invalid-feedback">
                    {{ $errors->first('password_confirmation') }}
                  </div>
                </div>
              </div>
              <div class="col-md-12 py-2">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-warning btn-block my-2">
                    Registrasi Data
                  </button>
                </div>
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