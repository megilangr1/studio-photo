@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Transaksi Pembelian Properti</h5>
        <div class="card-tools">
          <a href="{{ route('backend.pembelian.index') }}" class="btn btn-xs btn-danger px-2">
            <span class="fa fa-arrow-left"></span> &ensp; Kembali
          </a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('backend.pembelian.update', $pembelian->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian : </label>
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control {{ $errors->has('tanggal_pembelian') ? 'is-invalid':'' }}" value="{{ $pembelian->tanggal_pembelian }}" placeholder="Masukan Tanggal..." required autofocus>
                <span class="invalid-feedback">
                  {{ $errors->first('tanggal_pembelian') }}
                </span>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="nomor_kwitansi_pembelian">Nomor Kwitansi Pembelian : </label>
                <input type="string" name="nomor_kwitansi_pembelian" id="nomor_kwitansi_pembelian" class="form-control {{ $errors->has('nomor_kwitansi_pembelian') ? 'is-invalid':'' }}" value="{{ $pembelian->nomor_kwitansi_pembelian }}" placeholder="Masukan Nomor Kwitansi..." required>
                <span class="invalid-feedback">
                  {{ $errors->first('nomor_kwitansi_pembelian') }}
                </span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="studio_id">Studio Pembelian : </label>
                <select name="studio_id" id="studio_id" class="form-control {{ $errors->has('studio_id') ? 'is-invalid':''}}" style="width: 100%;" data-placeholder="Silahkan Pilih Studio" required>
                  <option value=""></option>
                  @foreach ($studio as $item)
                    <option value="{{ $item->id }}" {{ $pembelian->studio_id == $item->id ? 'selected':'' }}>{{ $item->nama_studio }}</option>
                  @endforeach
                </select>
                <span class="text-danger">
                  {{ $errors->first('studio_id') }}
                </span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label for="keterangan">Keterangan Lainnya : </label>
                <textarea name="keterangan" id="keterangan" cols="1" rows="1" class="form-control {{ $errors->has('keterangan') ? 'is-invalid':'' }}" placeholder="Masukan Keterangan Kategori">{{ $pembelian->keterangan }}</textarea>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" name="pakai_kas" id="pakai_kas" value="1" {{ $pembelian->kas != null ? 'checked':'' }}>
                  <label for="pakai_kas" class="custom-control-label">Dicatat Sebagai Pengeluaran Kas (Kas Saat Ini : Rp. {{ number_format($total, 0, ',' ,'.') }})</label>
                </div>
              </div>
            </div>
            <div class="col-12">
              @livewire('pembelian-properti.data-properti', ['old' => old(), 'pembelian' => $pembelian->detail->toArray()])
            </div>
            <div class="col-md-4">
              <button type="submit" class="btn btn-success btn-block">
                <span class="fa fa-check"></span> &ensp; Tambah Data Pembelian
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

    $('input').keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });
</script>
@endsection