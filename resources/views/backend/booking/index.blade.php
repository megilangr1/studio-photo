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
              <table class="table table-bordered m-0">
                <thead>
                  <tr>
                    <th class="text-center" width="5%">No.</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal Booking</th>
                    <th>Nama Pemesan</th>
                    <th class="text-center">Bukti Pembayaran</th>
                    <th class="text-center">Status Pembayaran</th>
                    <th class="text-center">Status Booking</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($bookings as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($bookings->currentpage()-1) * $bookings->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ $item->kode_booking }}</td>
                      <td class="align-middle">{{ date('d/m/Y', strtotime($item->tanggal_booking)) }} | {{ $item->jam_mulai }}</td>
                      <td class="align-middle">{{ $item->nama_pemesan }}</td>
                      <td class="align-middle text-center">
                        @if ($item->file_bukti_pembayaran != null)
                          <a href="{{ asset($item->file_path) }}" data-toggle="lightbox" data-title="{{ $item->kode_booking }}">
                            <span id="see_file_bap" class="btn btn-sm btn-info mx-1" style="line-height: normal !important;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Melihat File">Lihat File</span>
                          </a>
                        @else
                          Tidak Ada File
                        @endif
                      </td>
                      <td class="align-middle text-center">
                        @switch($item->status_bayar)
                            @case(0)
                              <span class="btn btn-warning btn-sm">
                                Belum di-Bayar
                              </span>
                              @break
                            @case(1)
                              <span class="btn btn-info btn-sm">
                                DP
                              </span>
                                @break
                            @case(2)
                              <span class="btn btn-info btn-sm">
                                Lunas
                              </span>
                            @default
                                
                        @endswitch
                      </td>
                      <td class="align-middle text-center">
                        @switch($item->status_booking)
                            @case(0)
                              <span class="btn btn-warning btn-sm">
                                Menunggu Konfirmasi
                              </span>
                              @break
                            @case(1)
                              <span class="btn btn-info btn-sm">
                                Terkonfirmasi
                              </span>
                                @break
                            @case(2)
                              <span class="btn btn-danger btn-sm">
                                Di-Tolak
                              </span>
                            @default
                                
                        @endswitch
                      </td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                        @if ($item->admin_id == null && $item->file_bukti_pembayaran != null)
                          <form action="{{ route('backend.booking.confirm', $item->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-success borad">
                              <span class="fa fa-check"></span>
                            </button>
                          </form>
                          <form action="{{ route('backend.booking.reject', $item->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-danger borad">
                              <span class="fa fa-times"></span>
                            </button>
                          </form>
                        @else 
                          @if ($item->status_booking == 2)
                            <form action="{{ route('backend.booking.confirm', $item->id) }}" method="post">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-sm btn-success borad">
                                <span class="fa fa-check"></span>
                              </button>
                            </form>
                            <form action="{{ route('backend.booking.destroy', $item->id) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger borad">
                                <span class="fa fa-trash"></span>
                              </button>
                            </form>
                          @else
                            <a href="{{ route('backend.booking.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                              <span class="fa fa-edit"></span>
                            </a>
                            <form action="{{ route('backend.booking.destroy', $item->id) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger borad">
                                <span class="fa fa-trash"></span>
                              </button>
                            </form>
                          @endif
                        @endif
                            
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="align-middle text-center">Belum Data Reservasi.</td>
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
              {{ $bookings->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection