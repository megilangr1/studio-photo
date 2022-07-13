@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-box text-primary"></span> &ensp; Data Booking / Reservasi Pemotretan</h5>
        <div class="card-tools">
          <a href="{{ route('backend.booking.create') }}" class="btn btn-xs btn-primary px-2">
            <span class="fa fa-plus"></span> &ensp; Tambah Data
          </a>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              {{-- <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No.</th>
                    <th>Nama Paket</th>
                    <th>Harga</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($pakets as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($pakets->currentpage()-1) * $pakets->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ $item->nama_paket }}</td>
                      <td class="align-middle">Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                          <a href="{{ route('backend.paket.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                            <span class="fa fa-edit"></span>
                          </a>
                          <form action="{{ route('backend.paket.destroy', $item->id) }}" method="post">
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
                      <td colspan="6" class="align-middle text-center">Belum Data Paket.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-12">
            <div class="float-right">
              {{-- {{ $pakets->links() }} --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection