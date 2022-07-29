@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-box text-primary"></span> &ensp; Buku Kas</h5>
        <div class="card-tools">
          <button type="button" class="btn btn-danger btn-xs mx-1" data-toggle="modal" data-target="#print-filter" data-backdrop="static" data-keyboard="false">
            &ensp; <span class="fa fa-print"></span> &ensp;
            Print Data
          </button>
          <a href="{{ route('backend.kas.create') }}" class="btn btn-xs btn-primary px-2">
            <span class="fa fa-plus"></span> &ensp; Tambah Data
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <h6 class="bg-primary text-center font-weight-bold px-4 py-2">Total Uang Kas : Rp. {{ number_format($total, 2, ',', '.') }}</h6>
          </div>
          <div class="col-12">
            <div class="table-responsive">
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No.</th>
                    <th class="text-center" width="10%">Tanggal</th>
                    <th>Asal Uang</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($kas as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($kas->currentpage()-1) * $kas->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle text-center">{{ date('m/d/Y', strtotime($item->tanggal_data)) }}</td>
                      <td class="align-middle">{{ $item->asal_uang }}</td>
                      <td class="align-middle">Rp. {{ number_format($item->nominal, 2, ',', '.') }}</td>
                      <td class="align-middle">{{ $item->keterangan ?? 'Tidak Ada Keterangan' }}</td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                          @if ($item->transaction_id == null)
                            <a href="{{ route('backend.kas.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                              <span class="fa fa-edit"></span>
                            </a>
                            <form action="{{ route('backend.kas.destroy', $item->id) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger borad">
                                <span class="fa fa-trash"></span>
                              </button>
                            </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="align-middle text-center">Belum Data Kategori.</td>
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
              {{ $kas->links() }}
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
        <h4 class="modal-title">Print Data Transaksi Perolehan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('backend.print-data.data-kas') }}" target="_blank" method="post">
          @csrf
          <div class="row">
            <div class="col-md-6 mb-2">
              <div class="form-group">
                <label>Tanggal Booking:</label>
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