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
            <h2>Laporan Data Transaksi Pembelian Properti</h2>
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
      </table>
      <hr>
      <table class="table table-bordered text-xs">
        <thead>
          <tr>
            <th class="align-middle text-center" width="5%">No.</th>
            <th class="align-middle text-center" width="10%">Tanggal Pembelian</th>
            <th class="align-middle">Nomor Kwitansi</th>
            <th class="align-middle">Jumlah Barang</th>
            <th class="align-middle">Jumlah Pembelian</th>
            <th class="align-middle">Pakai Kas</th>
            <th class="align-middle">Keterangan</th>
          </tr>
        </thead> 
        <tbody>
          @forelse ($data as $item)
            @php
              $total = 0;
              foreach ($item->detail as $key => $value) {
                $total = $total + ( (double) $value->jumlah * (double) $value->harga );
              }
            @endphp
            <tr>
              <td class="align-middle text-center">{{ $loop->iteration }}.</td>
              <td class="align-middle">{{ date('d/m/Y', strtotime($item->tanggal_pembelian)) }}</td>
              <td class="align-middle">{{ $item->nomor_kwitansi_pembelian }}</td>
              <td class="align-middle">{{ $item->detail->count('id') }} Barang</td>
              <td class="align-middle font-weight-bold" style="text-align: right;">
                <div style="float: left;">Rp. </div>
                {{ number_format($total, 0, ',', '.') }}
              </td>
              <td class="align-middle text-center">{{ $item->kas != null ? 'Ya' : 'Tidak' }}</td>
              <td class="align-middle text-center">{{ $item->keterangan ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="align-middle text-center">Belum Ada Data.</td>
            </tr>
          @endforelse
          <tr>
            <td colspan="4" style="text-align: right !important;">
              <b>Total : </b>
            </td>
            <td colspan="2" class="font-weight-bold">
              Rp. &ensp; {{ number_format($total, 0, ',', '.') }}
            </td>
            <td>&ensp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </body>

</html>