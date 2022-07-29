@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-circle text-primary"></span> &ensp; Buat Pencatatan Kas</h5>
        <div class="card-tools">
          <a href="{{ route('backend.kas.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <h6 class="bg-primary text-center font-weight-bold px-4 py-2">Uang Kas Saat Ini : Rp. {{ number_format($total, 2, ',', '.') }}</h6>
          </div>
        </div>
        <form action="{{ route('backend.kas.store') }}" method="post">
          @csrf
          <div class="row px-3 py-2">
            <div class="col-md-2">
              <div class="form-group">
                <label for="tanggal_data">Tanggal Pencatatan : </label>
                <input type="date" name="tanggal_data" id="tanggal_data" class="form-control {{ $errors->has('tanggal_data') ? 'is-invalid':'' }}" value="{{ old('tanggal_data') }}" placeholder="Masukan Nama Kategori..." required autofocus>
                <span class="invalid-feedback">
                  {{ $errors->first('tanggal_data') }}
                </span>
              </div>
            </div>
            <div class="col-md-3">
              <label for="jenis_data">Jenis Transaksi : </label>
              <select name="jenis_data" id="jenis_data" class="form-control {{ $errors->has('jenis_data') ? 'is-invalid':'' }}" required>
                <option value="">- Pilih -</option>
                <option value="1" {{ old('jenis_data') == '1' ? 'selected':'' }}>Pemasukan</option>
                <option value="2" {{ old('jenis_data') == '2' ? 'selected':'' }}>Pengeluaran</option>
              </select>
              <span class="invalid-feedback">
                {{ $errors->first('jenis_data') }}
              </span>
            </div>
            <div class="col-md-7">
              <div class="form-group">
                <label for="asal_uang">Asal / Tujuan : </label>
                <input type="text" name="asal_uang" id="asal_uang" class="form-control {{ $errors->has('asal_uang') ? 'is-invalid':'' }}" value="{{ old('asal_uang') }}" placeholder="Masukan Keterangan Asal / Tujuan..." required>
                <span class="invalid-feedback">
                  {{ $errors->first('asal_uang') }}
                </span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="form-group">
                <label for="nominal">Nominal : </label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text">Rp. </div>
                  </div>
                  <input type="number" name="nominal" id="nominal" class="form-control {{ $errors->has('nominal') ? 'is-invalid':'' }}" value="{{ old('nominal') }}" placeholder="Masukan Nominal..." required>
                  <span class="invalid-feedback">
                    {{ $errors->first('nominal') }}
                  </span>
                </div>
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
                <span class="fa fa-check"></span> &ensp; Tambah Data Pencatatan Kas
              </button> 
            </div>
          </div>
        </form>
      </div>
      <div class="card-footer">

      </div>
    </div>
  </div>
</div>
@endsection