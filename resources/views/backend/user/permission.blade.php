@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-key text-info"></span> &ensp; Atur Has Akses Pengguna</h5>
        <div class="card-tools">
          <a href="{{ route('backend.user.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.user.sync', $user->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-12">
              <h6 class="font-weight-bold m-0 p-0">Nama Pengguna : {{ $user->name }}</h6>
              <h6 class="font-weight-bold m-0 p-0">Email Pengguna : {{ $user->email }}</h6>
              <hr>
            </div>
            <div class="col-12">
              <div class="form-group">
              <label for="permission">Jenis Pengguna / Level Pengguna : </label>
                <select name="role[]" id="role" class="form-control select2" multiple="multiple" data-placeholder="Level Pengguna" style="width: 100%;">
                  @foreach ($roles as $item)
                    <option value="{{ $item->id }}" {{ in_array($item->id, $user->roles()->pluck('id')->toArray()) ? 'selected':'' }}>{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
              <label for="permission">Hak Akses Modul Program : </label>
                <select name="permission[]" id="permission" class="form-control select2" multiple="multiple" data-placeholder="Hak Akses Modul" style="width: 100%;">
                  @foreach ($permission as $item)
                    <option value="{{ $item->id }}" {{ in_array($item->id, $user->permissions()->pluck('id')->toArray()) ? 'selected':'' }}>{{ $item->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <button type="submit" class="btn btn-block btn-success">
                  <span class="fa fa-check"></span> Atur Hak Akses Pengguna
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  $(document).ready(function () {
    $('#role').select2();
    $('#permission').select2();
  });
</script>
@endsection