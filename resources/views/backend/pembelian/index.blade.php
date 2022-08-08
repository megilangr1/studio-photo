@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-box text-primary"></span> &ensp; Data Pembelian Properti</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-danger btn-xs mx-1" data-toggle="modal" data-target="#print-filter" data-backdrop="static" data-keyboard="false">
            &ensp; <span class="fa fa-print"></span> &ensp;
            Print Data
          </button>
          <a href="{{ route('backend.pembelian.create') }}" class="btn btn-xs btn-primary px-2">
            <span class="fa fa-plus"></span> &ensp; Tambah Data
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No.</th>
                    <th>Tanggal Pembelian</th>
                    <th>Nomor Kwitansi</th>
                    <th>Jumlah Barang</th>
                    <th>Jumlah Pembelian</th>
                    <th>Pakai Kas</th>
                    <th>Keterangan</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($pembelian as $item)
                    @php
                      $total = 0;
                      foreach ($item->detail as $key => $value) {
                        $total = $total + ( (double) $value->jumlah * (double) $value->harga );
                      }
                    @endphp
                    <tr>
                      <td class="align-middle text-center">{{ ($pembelian->currentpage()-1) * $pembelian->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ date('d/m/Y', strtotime($item->tanggal_pembelian)) }}</td>
                      <td class="align-middle">{{ $item->nomor_kwitansi_pembelian }}</td>
                      <td class="align-middle">{{ $item->detail()->count('id') }} Barang</td>
                      <td class="align-middle text-right font-weight-bold">
                        <div class="float-left">Rp.</div> 
                        {{ number_format($total, 0, ',', '.') }}
                      </td>
                      <td class="align-middle">
                        @if ($item->kas != null)
                          <span class="btn btn-xs btn-block btn-success">
                            <span class="fa fa-check"></span>
                          </span>
                        @else
                          <span class="btn btn-xs btn-block btn-danger">
                            <span class="fa fa-times"></span>
                          </span>
                        @endif
                      </td>
                      <td class="align-middle">{{ $item->keterangan ?? 'Tidak Ada Keterangan' }}</td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                          <a href="{{ route('backend.pembelian.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                            <span class="fa fa-edit"></span>
                          </a>
                          <form action="{{ route('backend.pembelian.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger borad">
                              <span class="fa fa-trash"></span>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" class="align-middle text-center">Belum Ada Data Pembelian.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-12">
            <div class="float-right">
              {{ $pembelian->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="print-filter" wire:ignore>
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Print Data Pembelian Properti</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('backend.print-data.data-pembelian-properti') }}" target="_blank" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label>Tanggal Pembelian:</label>
                <input type="date" name="date_start" class="form-control">
              </div>
            </div>
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label>Hingga Tanggal :</label>
                <input type="date" name="date_end" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <button type="submit" class="btn btn-block btn-success">
                  <span class="fa fa-print"></span> &ensp; Buat Print Data
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer float-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
      </div>
    </div>
  </div>
</div>
@endsection