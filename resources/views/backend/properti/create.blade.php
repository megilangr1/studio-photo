@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Buat Data Properti</h5>
        <div class="card-tools">
          <a href="{{ route('backend.properti.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.properti.store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="studio_id">Studio Properti : </label>
                <select name="studio_id" id="studio_id" class="form-control {{ $errors->has('studio_id') ? 'is-invalid':''}}" style="width: 100%;" data-placeholder="Silahkan Pilih Studio">
                  <option value=""></option>
                  @foreach ($studio as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_studio }}</option>
                  @endforeach
                </select>
                <span class="text-danger">
                  {{ $errors->first('studio_id') }}
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="kategori_id">Kategori Properti : </label>
                <select name="kategori_id" id="kategori_id" class="form-control {{ $errors->has('kategori_id') ? 'is-invalid':''}}" style="width: 100%;" data-placeholder="Silahkan Pilih Studio">
                  <option value=""></option>
                  @foreach ($kategori as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                  @endforeach
                </select>
                <span class="text-danger">
                  {{ $errors->first('kategori_id') }}
                </span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="nama_properti">Nama Properti : </label>
                <input type="text" name="nama_properti" id="nama_properti" class="form-control {{ $errors->has('nama_properti') ? 'is-invalid':'' }}" value="{{ old('nama_properti') }}" placeholder="Masukan Nama Properti..." required>
                <span class="invalid-feedback">
                  {{ $errors->first('nama_properti') }}
                </span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="tanggal_masuk">Tanggal Masuk : </label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control {{ $errors->has('tanggal_masuk') ? 'is-invalid':'' }}" value="{{ old('tanggal_masuk') }}" placeholder="Pilih Tanggal..." required>
                <span class="invalid-feedback">
                  {{ $errors->first('tanggal_masuk') }}
                </span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="kondisi">Kondisi : </label>
                <select name="kondisi" id="kondisi" class="form-control">
                  <option value="">- Pilih Kondisi -</option>
                  <option value="Baik">Baik</option>
                  <option value="Rusak Ringan">Rusak Ringan</option>
                  <option value="Rusak Berat / Tidak Dapat di-Pakai">Rusak Berat / Tidak Dapat di-Pakai</option>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="keterangan">Keterangan Lainnya : </label>
                <textarea name="keterangan" id="keterangan" cols="1" rows="1" class="form-control {{ $errors->has('keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Properti">{{ old('keterangan') }}</textarea>
              </div>
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block">
                <span class="fa fa-check"></span> &ensp; Tambah Data Properti
              </button>
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
  $(document).ready(function() {
    $('#studio_id').select2();
    $('#kategori_id').select2();
  });
</script>
@endsection