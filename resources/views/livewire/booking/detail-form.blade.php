<div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="nama_pemesan" wire:click="dummy()">Nama Pemesan : </label>
        <input type="text" wire:model="pemesanan.nama_pemesan" name="nama_pemesan" id="nama_pemesan" class="form-control {{ $errors->has('pemesanan.nama_pemesan') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pemesan..." required autofocus>
        <div class="invalid-feedback">
          {{ $errors->first('pemesanan.nama_pemesan') }}
        </div>
      </div>
    </div>
    <div class="col-md-5 {{ $errors->has('pemesanan.id_paket') ? 'text-danger':'' }}">
      <div class="form-group">
        <label for="paket">Paket : </label>
        <div wire:ignore>
          <select name="paket" id="paket" class="form-control" data-placeholder="Pilih Paket Foto" style="width: 100%;">	
            <option value=""></option>
            @foreach ($dataPaket as $item)
              <option value="{{ $item['id'] }}">{{ $item['nama_paket'] }}</option>
            @endforeach
          </select>
        </div>
        <div class="text-danger text-sm">
          {{ $errors->first('pemesanan.id_paket') }}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="nominal_booking">Harga Paket : </label>
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">Rp. </div>
          </div>
          <input type="text" wire:model="pemesanan.nominal_booking" name="nominal_booking" id="nominal_booking" class="form-control {{ $errors->has('pemesanan.nominal_booking') ? 'is-invalid':'' }}" placeholder="Silahkan Pilih Paket..." required disabled>
          <div class="invalid-feedback">
            {{ $errors->first('pemesanan.nominal_booking') }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="tanggal_booking">Tanggal Booking : </label>
        <input type="date" wire:model="pemesanan.tanggal_booking" name="tanggal_booking" id="tanggal_booking" class="form-control {{ $errors->has('pemesanan.tanggal_booking') ? 'is-invalid':'' }}" required >
        <div class="invalid-feedback">
          {{ $errors->first('pemesanan.tanggal_booking') }}
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group {{ $errors->has('pemesanan.jam_mulai') ? 'text-danger' : '' }}" >
        <label for="jam">Jam : </label>
        <div class="" wire:ignore>
          <select name="jam" id="jam" class="form-control" data-placeholder="Pilih Jam Pemesanan" style="width: 100%;">
            <option value=""></option>
            @foreach ($jam as $item)
              <option value="{{ $item }}">{{ $item }}</option>
            @endforeach
          </select>
        </div>
        <div class="text-danger text-xs">
          {{ $errors->first('pemesanan.jam_mulai') }}
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="durasi">Durasi Paket : </label>
        <div class="input-group">
          @if ($paket != null)
            <input type="text" wire:model="paket.durasi" name="durasi" id="durasi" class="form-control {{ $errors->has('pemesanan.durasi') ? 'is-invalid':'' }}" placeholder="0" required disabled>
          @else
            <input type="text" name="durasi" id="durasi" class="form-control {{ $errors->has('pemesanan.durasi') ? 'is-invalid':'' }}" placeholder="0" disabled>
          @endif
          <div class="input-group-append">
            <span class="input-group-text">
              Menit
            </span>
          </div>
        </div>
        <div class="invalid-feedback">
          {{ $errors->first('pemesanan.durasi') }}
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="jam_selesai">Jam Selesai : </label>
        <input type="text" wire:model="pemesanan.jam_selesai" name="jam_selesai" id="jam_selesai" class="form-control {{ $errors->has('pemesanan.jam_selesai') ? 'is-invalid':'' }}" placeholder="00:00" required disabled>
        <div class="invalid-feedback">
          {{ $errors->first('pemesanan.jam_selesai') }}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="jumlah_orang">Jumlah Orang : </label>
        <div class="input-group">
          <input type="number" wire:model="pemesanan.jumlah_orang" name="jumlah_orang" id="jumlah_orang" class="form-control {{ $errors->has('pemesanan.jumlah_orang') ? 'is-invalid':'' }}" placeholder="0" required>
          <div class="input-group-append">
            <span class="input-group-text">
              Orang
            </span>
          </div>
					<div class="invalid-feedback">
						{{ $errors->first('pemesanan.jumlah_orang') }}
					</div>
        </div>
      </div>
    </div>
		<div class="col-md-4">
      <div class="form-group">
        <label for="rekening_transfer">Rekening Pembayaran : </label>
				<select wire:model="pemesanan.rekening_transfer" name="rekening_transfer" id="rekening_transfer" class="form-control {{ $errors->has('pemesanan.rekening_transfer') ? 'ís-invalid':'' }}">
					<option value="">- Pilih -</option>
					<option value="Bayar Langsung">Bayar Langsung</option>
					<option value="BCA">BCA</option>
					<option value="BRI">BRI</option>
				</select>
				<div class="invalid-feedback">
					{{ $errors->first('pemesanan.rekening_transfer') }}
				</div>
      </div>
    </div>
		<div class="col-md-4">
			<div class="form-group" wire:click="dummy()">
				<label for="status_bayar">Status Pembayaran : </label>
				<select wire:model="pemesanan.status_bayar" name="status_bayar" id="status_bayar" class="form-control">
					<option value="">- Pilih -</option>
					<option value="0">Belum Ada Pembayaran</option>
					<option value="1">Baru DP</option>
					<option value="2">Sudah Lunas</option>
				</select>
				<div class="invalid-feedback">
					{{ $errors->first('pemesanan.nominal_dp') }}
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group"> 
				<label for="file_bukti_pembayaran">Bukti Transfer Pembayaran :</label>
				<div class="float-right">
					@if ($pemesanan['file_bukti_pembayaran'] != null)
						<span class="badge badge-success mx-1" style="line-height: normal !important;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Membatalkan File Upload" wire:click="resetFile('bap')">File di-Unggah</span>
					@endif
					{{-- @if ($editPaket != null && $editPaket['file_bukti_pembayaran'] != null)
						<a href="{{ asset($editPaket['file_path']) }}" data-toggle="lightbox" data-title="{{ $editPaket['nama_paket'] }}">
							<span id="see_file_bap" class="btn badge badge-primary mx-1" style="line-height: normal !important;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Melihat File Saat Ini">File Saat Ini</span>
						</a>
					@endif --}}
				</div>
				<div style="{{ $errors->has('pemesanan.file_bukti_pembayaran') ? 'border: 1px solid #dc3545 !important; border-radius:4px;':'' }}">
					<div class="input-group" style="">
						<div class="custom-file">
							<input type="file" wire:model="pemesanan.file_bukti_pembayaran" class="custom-file-input" name="file_bukti_pembayaran" id="file_bukti_pembayaran">
							<label class="custom-file-label borad" id="upload_bastbp_label" for="file_bukti_pembayaran" >{{ $pemesanan['file_bukti_pembayaran'] != null ? $booking['kode_booking'] : 'Silahkan Pilih File Untuk di-Upload.' }}</label>
						</div>
					</div>
				</div>
				<div class="text-danger text-xs pt-1">
					{{ $errors->first('pemesanan.file_bukti_pembayaran') }}
				</div>
			</div>
		</div>
		<div class="col-md-4">
      <div class="form-group">
        <label for="nominal_dp">Nominal DP : </label>
        <div class="input-group">
          <div class="input-group-prepend">
            <div class="input-group-text">Rp. </div>
          </div>
          <input type="text" wire:model="pemesanan.nominal_dp" name="nominal_dp" id="nominal_dp" class="form-control {{ $errors->has('pemesanan.nominal_dp') ? 'is-invalid':'' }}" placeholder="0..." required>
          <div class="invalid-feedback">
            {{ $errors->first('pemesanan.nominal_dp') }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <hr class="mt-1 mb-3">
    </div>
    <div class="col-md-4">
      <button class="btn btn-success btn-block" wire:click="tambahData">
        <span class="fa fa-plus"></span> &ensp; Buat Data Booking / Reservasi
      </button>
    </div>
  </div>
</div>

@push('script')
<script>
  $(document).ready(function () {
    $('#jam').select2();
    $('#paket').select2();

    $('#jam').on('change', function() {
      var value = $(this).val();

      Livewire.emit('setJam', value);
    });

    $('#paket').on('change', function() {
      var value = $(this).val();

      Livewire.emit('setPaket', value);
    });

    Livewire.on('resetJam', function() {
      $('#jam').val('').trigger('change');
    });

    Livewire.on('refreshJam', function(data) {
      // $('#jam').select2("destroy");
      $('#jam').find('option').remove().end().append('<option value=""></option>').val("");
      if (Object.keys(data).length > 0) {
        $.each(data, function (index, value) { 
          $('#jam').append('<option value="'+value+'">'+value+'</option>')
        });

        $('#jam').select2("destroy").select2();
        $('#jam').val("").trigger('change');
      }
    });

		Livewire.on('setJamVal', function(data) {
			$('#jam').val(data).trigger('change');
		});

		Livewire.on('setPaketVal', function(data) {
			$('#paket').val(data).trigger('change');
		});
  });
</script>

@if ($booking != null)
<script>
	$(document).ready(function () {
		Livewire.emit('setVal');
	});
</script>
@endif
@endpush