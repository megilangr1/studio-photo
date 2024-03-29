@extends('frontend.layouts.master') 

@section('css')
<style>
	.form-group {
		padding: 10px 0px !important;
	}

	.form-group label {
		padding: 3px !important;
	}
</style>
@endsection

@section('content')
<hr>

<main id="main">
  <div class="row">
    <div class="col-12">
      <h5 class="text-center">Data Reservasi Studio</h5>
      <hr>
    </div>
    <div class="col-12 px-4">
      @if (session()->has('success') || session()->has('error'))
        <div class="row">
          <div class="col-md-4">&ensp;</div>
          <div class="col-md-4">
            @if (session()->has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            @if (session()->has('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!! session('error') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
          </div>
          <div class="col-md-4">&ensp;</div>
        </div>
      @endif
      <div class="row">
        <div class="col-md-1">&ensp;</div>
        <div class="col-md-10">
          <table class="table">
            <thead style="font-size: 14px !important;">
              <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Kode Booking</th>
                <th class="text-center">Tanggal Reservasi</th>
                <th class="text-center">Paket</th>
                <th class="text-center">Minimum DP</th>
                <th class="text-center">Total Nominal Reservasi</th>
                <th class="text-center">Status Booking</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody style="font-size: 13px !important;">
              @forelse ($booking as $item)
                <tr>
                  <td class="align-middle text-center">{{ $loop->iteration }}.</td>
                  <td class="align-middle text-center">
                    @if ($item->file_bukti_pembayaran != null)
                      <a class="btn btn-success" target="_blank" href="{{ asset($item->file_path) }}" style="padding: 3px 3px; font-size: 12px;" style="border-radius: 0px !important;">
                        {{ $item->kode_booking }}
                      </a>
                    @else 
                      {{ $item->kode_booking }}
                    @endif

                  </td>
                  <td class="align-middle text-center">{{ date('d/m/Y', strtotime($item->tanggal_booking)) }} | {{ $item->jam_mulai }}</td>
                  <td class="align-middle text-center">{{ $item->paket->nama_paket }}</td>
                  <td class="align-middle text-center">Rp. {{ number_format($item->nominal_booking / 2, 0, ',', '.') }}</td>
                  <td class="align-middle text-center">Rp. {{ number_format($item->total_pembayaran, 0, ',', '.') }}</td>
                  <td class="align-middle text-center">
                    @switch($item->status_booking)
                        @case(1)
                          <button href="#" class="btn btn-success" style="padding: 3px 3px; font-size: 12px;">
                            Booking Berhasil
                          </button>
                          @break
                        @case(2)
                          <button href="#" class="btn btn-danger" style="padding: 3px 3px; font-size: 12px;">
                            Di-Batalkan
                          </button>
                          @break
                        @default
                        @if ($item->created_at < now())
                          <a href="{{ route('cara-bayar', $item->kode_booking) }}" target="_blank" class="btn btn-warning" style="padding: 3px 3px; font-size: 12px;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Melihat Cara Bayar..">
                            Belum di-Konfirmasi
                          </a>
                        @else
                          <button class="btn btn-warning" style="padding: 3px 3px; font-size: 12px;">
                            Belum di-Konfirmasi
                          </button>
                        @endif
                    @endswitch
                  </td>
                  <td class="align-middle text-center">
                    @switch($item->status_booking)
                        @case(1)
                          <div class="btn-group">
                            <a href="{{ route('hasil-foto', $item->kode_booking) }}" class="btn btn-secondary" style="padding: 3px 3px; font-size: 10px;" style="border-radius: 0px !important;">
                              Hasil Foto
                            </a>
                            @if ($item->gdrive_link != null)
                              <a href="{{ $item->gdrive_link }}" target="_blank" class="btn btn-success" style="padding: 3px 3px; font-size: 10px;" style="border-radius: 0px !important;">
                                Link Drive
                              </a>
                            @endif
                          </div>
                            @break
                        @case(2)
                          <a href="#" class="btn btn-secondary" style="padding: 3px 3px; font-size: 12px;" style="border-radius: 0px !important;">
                            Tidak Ada Aksi
                          </a>
                            @break
                        @default
                        <div class="btn-group">
                          @if ($item->created_at < now())
                            <button type="button" class="btn btn-warning uploadPembayaran" data-bs-toggle="modal" data-id="{{ $item->id }}" data-kode="{{ $item->kode_booking }}" data-bs-target="#exampleModal" style="padding: 3px 3px; font-size: 12px; border-radius: 0px !important;">
                              Pembayaran
                            </button>
                          @endif
                          <form action="{{ route('booking-cancel', $item->id) }}" method="post">
                            @csrf 
                            @method('PUT')
    
                            <button type="submit" class="btn btn-danger" style="padding: 3px 3px; font-size: 12px; border-radius: 0px !important;">
                              Batalkan
                            </button>
    
                          </form>
                        </div>
                    @endswitch
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8">
                    Belum Ada Data Booking.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="col-md-1">&ensp;</div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Upload Bukti Pembayaran - ( <b id="kode"></b> )</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('upload-pembayaran') }}" method="post" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
              <div class="col-12">
                <div class="form-group" style="padding-top: 0px !important;">
                  <label for="nominal">Nominal : </label>
                  <input type="number" name="nominal" id="nominal" class="form-control" placeholder="Silahkan Masukan Nominal DP sesuai yang di-Transferkan.." required>
                </div>
                <div class="form-group" style="padding-bottom: 0px !important;">
                  <label for="file">File Bukti Pembayaran</label>
                  <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <input type="hidden" name="id" id="id_booking">
              </div>
              <div class="col-md-4">
                <br>
                <button type="submit" class="btn btn-warning">
                  Upload Bukti Pembayaran
                </button>
              </div>
            </div>

          </form>
        </div>
        <div class="modal-footer float-right">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
</main>

@endsection

@section('script')
<script>
  $(document).ready(function () {
    $('.uploadPembayaran').on('click', function() {
      var id = $(this).data('id');
      var kode = $(this).data('kode');

      $('#id_booking').val(id);
      $('#kode').text(kode);

      console.log("OK");
    });
  });
</script>
@endsection