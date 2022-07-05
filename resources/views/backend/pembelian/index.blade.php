@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-box text-primary"></span> &ensp; Data Pembelian Properti</h5>
        <div class="card-tools">
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
                    <th>Keterangan</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($pembelian as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($pembelian->currentpage()-1) * $pembelian->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ date('d/m/Y', strtotime($item->tanggal_pembelian)) }}</td>
                      <td class="align-middle">{{ $item->nomor_kwitansi_pembelian }}</td>
                      <td class="align-middle">{{ $item->detail()->sum('jumlah') }} Barang</td>
                      <td class="align-middle">Rp. {{ number_format($item->detail()->sum('harga'), 0, ',', '.') }}</td>
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
                      <td colspan="7" class="align-middle text-center">Belum Data Pembelian.</td>
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
@endsection