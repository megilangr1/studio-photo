<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Print Data Booking</title>
      {{-- <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css"> --}}
      <style>
        body {
          margin: 0;
          font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
          font-size: 1rem;
          font-weight: 400;
          line-height: 1.5;
          color: #212529;
          text-align: left;
          background-color: #fff
        }

        .container,
        .container-fluid,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl {
          width: 100%;
          padding-right: 7.5px;
          padding-left: 7.5px;
          margin-right: auto;
          margin-left: auto
        }

        .table {
          width: 100%;
          margin-bottom: 1rem;
          color: #212529;
          background-color: transparent
        }

        .table td,
        .table th {
          padding: .75rem;
          vertical-align: top;
          border-top: 1px solid #dee2e6
        }

        .table thead th {
          vertical-align: bottom;
          border-bottom: 2px solid #dee2e6
        }

        .table tbody+tbody {
          border-top: 2px solid #dee2e6
        }

        .table-sm td,
        .table-sm th {
          padding: .3rem
        }

        .table-bordered {
          border: 1px solid #dee2e6
        }

        .table-bordered td,
        .table-bordered th {
          border: 1px solid #dee2e6
        }

        .table-bordered thead td,
        .table-bordered thead th {
          border-bottom-width: 2px
        }

        .table-borderless tbody+tbody,
        .table-borderless td,
        .table-borderless th,
        .table-borderless thead th {
          border: 0
        }

        .text-xs {
          font-size: .75rem !important
        }

        .m-0 {
          margin: 0 !important
        }

        .pt-1,
        .py-1 {
          padding-top: .25rem !important
        }

        .pr-0,
        .px-0 {
          padding-right: 0 !important
        }

        .text-center {
          text-align: center !important
        }

        .pr-2,
        .px-2 {
          padding-right: .5rem !important
        }

        .p-2 {
          padding: .5rem !important
        }

        .text-nowrap {
          white-space: nowrap !important
        }

        .font-weight-bold {
          font-weight: 700 !important
        }

        .float-left {
          float: left !important
        }

        .align-middle {
          vertical-align: middle !important
        }
      </style>
  </head>

  <body>
    <div class="container-fluid">
      <table class="table table-borderless text-xs m-0">
        <tr>
          <td colspan="2" style="text-align: center !important;">
            <h2>Laporan Data Transaksi Booking</h2>
          </td>
        </tr>
        <tr>
          <td style="padding: 0px 0px;" class="">Keterangan Tanggal : 
            <b>
              {{ date('d/m/Y', strtotime($start)) }}

              @if ($end != null)
              - {{ date('d/m/Y', strtotime($end)) }}
              @endif
            </b>
          </td>
        </tr>
        {{-- <tr>
          <td style="padding: 0px 0px;" class="">Kode Rekening Belanja</td>
          <td style="padding: 0px 0px;" class="text-center">:</td>
          <td style="padding: 0px 5px;" class=""><b>{{ $rekening['kode_rek_belanja'] }}</b></td>
        </tr>
        <tr>
          <td style="padding: 0px 0px;" class="">Nama Rekening Belanja</td>
          <td style="padding: 0px 0px;" class="text-center">:</td>
          <td style="padding: 0px 5px;" class=""><b>{{ $rekening['sub_rincian_objek'] }}</b></td>
        </tr>
        <tr>
          <td style="padding: 0px 0px;" class="">Total Keseluruhan</td>
          <td style="padding: 0px 0px;" class="text-center">:</td>
          <td style="padding: 0px 5px;" class=""><b>Rp. {{ number_format($total, $numberFormat, ',', '.') }}</b></td>
        </tr> --}}
      </table>
      <hr>
      <table class="table table-bordered text-xs">
        <thead>
          <tr>
            <th class="align-middle text-center" width="5%">No.</th>
            <th class="align-middle text-center" width="10%">Tanggal</th>
            <th class="align-middle">Paket</th>
            <th class="align-middle text-right" width="20%">Nominal</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $item)
            <tr>
              <td class="align-middle text-center p-2">{{ $loop->iteration }}.</td>
              <td class="align-middle text-center p-2">{{ date('d/m/Y', strtotime($item['tanggal_booking'])) }}</td>
              <td class="align-middle p-2">{{ $item['paket']['nama_paket'] }}</td>
              <td class="align-middle p-2 text-nowrap font-weight-bold" style="text-align: right !important;">
                <div style="float: left;">Rp. </div>{{ number_format($item['total_pembayaran'], 0, ',', '.') }}
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-center" colspan="4">Belum Ada Data Perolehan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </body>

</html>