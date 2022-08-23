<div>
	<div class="row">
		<div class="col-12">
			<ul class="nav nav-tabs" id="main-tab" role="tablist">
        <li class="nav-item">
          <a class="nav-link small-nav-link active" wire:ignore.self id="informasi-tab" data-toggle="pill" href="#informasi" role="tab" aria-controls="informasi" aria-selected="true">
            Informasi Perolehan
          </a>
        </li>
				<li class="nav-item">
					<a class="nav-link small-nav-link" wire:ignore.self id="hasil-tab" data-toggle="pill" href="#hasil" role="tab" aria-controls="hasil" aria-selected="true">
						Hasil Foto
					</a>
				</li>
        <li class="nav-item">
          <div wire:loading>
            <a class="nav-link small-nav-link disabled" id="loading-tab" data-toggle="pill" href="#loading" role="tab" aria-controls="loading" aria-selected="false">
              <span class="fa fa-undo"></span> Sedang Memperbaharui Data
            </a>
          </div>
        </li>
      </ul>
			<div class="tab-content my-1" id="main-tabContent">
        <div class="tab-pane fade show active" wire:ignore.self id="informasi" role="tabpanel" aria-labelledby="informasi-tab">
					<div class="row py-1 px-4">
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
						<div class="col-md-2">
							<div class="form-group">
								<label for="nominal_dp">Nominal DP : </label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">Rp. </div>
									</div>
									<input type="text" wire:model="pemesanan.nominal_dp" name="nominal_dp" id="nominal_dp" class="form-control {{ $errors->has('pemesanan.nominal_dp') ? 'is-invalid':'' }}" placeholder="0..." required {{ $pemesanan['status_bayar'] == 1 || $pemesanan['status_bayar'] == 2 ? 'disabled':'' }}>
									<div class="invalid-feedback">
										{{ $errors->first('pemesanan.nominal_dp') }}
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="rekening_transfer">Rekening Pembayaran : </label>
								<select wire:model="pemesanan.rekening_transfer" name="rekening_transfer" id="rekening_transfer" class="form-control {{ $errors->has('pemesanan.rekening_transfer') ? 'ís-invalid':'' }}">
									<option value="">- Pilih -</option>
									<option value="Bayar Langsung">Bayar Langsung</option>
									<option value="Transfer BCA">Transfer BCA</option>
									<option value="Transfer BRI">Transfer BRI</option>
								</select>
								<div class="invalid-feedback">
									{{ $errors->first('pemesanan.rekening_transfer') }}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="status_bayar" wire:click="dummy()">Status Pembayaran : </label>
								<select wire:model="pemesanan.status_bayar" name="status_bayar" id="status_bayar" class="form-control">
									<option value="">- Pilih -</option>
									<option value="0">Belum Ada Pembayaran</option>
									<option value="1">Baru DP</option>
									<option value="2">Sudah Lunas</option>
								</select>
								<div class="invalid-feedback">
									{{ $errors->first('pemesanan.status_bayar') }}
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label for="file_bukti_pembayaran">Bukti Pembayaran :</label>
								<div class="float-right">
									@if ($pemesanan['file_bukti_pembayaran'] != null)
										<span class="badge badge-success mx-1" style="line-height: normal !important;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Membatalkan File Upload" wire:click="resetFile('bap')">File di-Unggah</span>
									@endif
									@if ($pemesanan['file_bukti_pembayaran_now'] != null)
										<a href="{{ asset($pemesanan['file_path_now']) }}" data-toggle="lightbox" data-title="{{ $booking['kode_booking'] }}">
											<span id="see_file_bap" class="btn badge badge-primary mx-1" style="line-height: normal !important;" data-toggle="offcanvas" role="button" data-tooltip="tooltip" title="Klik Untuk Melihat File Saat Ini">File Saat Ini</span>
										</a>
									@endif
								</div>
								<div style="{{ $errors->has('pemesanan.file_bukti_pembayaran') ? 'border: 1px solid #dc3545 !important; border-radius:4px;':'' }}">
									<div class="input-group">
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
						<div class="col-md-12">
							<h5>Add-On Pemotretan :</h5>
							<hr class="my-1">
						</div>
						<div class="col-md-12 px-3">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label for="tambah_foto">Tambah Foto : </label>
										<div class="input-group">
											<input type="number" wire:model="pemesanan.tambah_foto" name="tambah_foto" id="tambah_foto" class="form-control {{ $errors->has('pemesanan.tambah_foto') ? 'is-invalid':'' }}" placeholder="0" >
											<div class="input-group-append">
												<div class="input-group-text">Foto</div>
											</div>
											<div class="invalid-feedback">
												{{ $errors->first('pemesanan.tambah_foto') }}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="harga_paket_tambah_foto">Harga Paket Tambah Foto : </label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">Rp. </div>
											</div>
											<input type="number" wire:model="pemesanan.harga_paket_tambah_foto" name="harga_paket_tambah_foto" id="harga_paket_tambah_foto" class="form-control {{ $errors->has('pemesanan.harga_paket_tambah_foto') ? 'is-invalid':'' }}" placeholder="0" disabled>
											<div class="input-group-append">
												<div class="input-group-text">
													per-Foto
												</div>
											</div>
											<div class="invalid-feedback">
												{{ $errors->first('pemesanan.harga_paket_tambah_foto') }}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<label for="informasi_tambahan">Keterangan Harga Paket : </label>
										<div class="input-group">
											<input type="number" wire:model="paket.informasi_tambahan" name="informasi_tambahan" id="informasi_tambahan" class="form-control {{ $errors->has('paket.informasi_tambahan') ? 'is-invalid':'' }}" placeholder="-" disabled>
											<div class="invalid-feedback">
												{{ $errors->first('paket.informasi_tambahan') }}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="harga_akhir_tambah_foto">Nominal Akhir Tambah Foto : </label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">Rp. </div>
											</div>
											<input type="number" wire:model="pemesanan.harga_akhir_tambah_foto" name="harga_akhir_tambah_foto" id="harga_akhir_tambah_foto" class="form-control {{ $errors->has('pemesanan.harga_akhir_tambah_foto') ? 'is-invalid':'' }}" placeholder="0">
											<div class="input-group-append">
												<div class="input-group-text">
													untuk {{ $pemesanan['tambah_foto'] }} Foto Tambahan
												</div>
											</div>
											<div class="invalid-feedback">
												{{ $errors->first('pemesanan.harga_akhir_tambah_foto') }}
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<h6 class="font-weight-bold">Biaya Tambahan Pake Lainnya :</h6>
									<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>Nama Biaya</th>
													<th class="text-center">Nominal Biaya</th>
													<th class="text-center">Keterangan</th>
													<th class="text-center">#</th>
												</tr>
											</thead>
											<tbody>
													@forelse ($biayaLainnya as $item)
														<tr>
															<td class="align-middle">{{ $item['nama_biaya'] }}</td>
															<td class="align-middle text-center">Rp. {{ $item['nominal_biaya'] }}</td>
															<td class="align-middle text-center">{{ $item['keterangan'] ?? '-' }}</td>
															<td class="align-middle text-center">
																@if (isset($addOn[$item['id']]) && $addOn[$item['id']] == true)
																	<button class="btn btn-sm btn-danger" wire:click="batalkanBiaya('{{ $item['id'] }}')">
																		<span class="fa fa-times"></span> &ensp; Batalkan
																	</button>
																@else
																	<button class="btn btn-sm btn-success" wire:click="tambahBiaya('{{ $item['id'] }}')">
																		<span class="fa fa-plus"></span> &ensp; Tambah Biaya
																	</button>
																@endif
															</td>
														</tr>
													@empty
														<tr>
															<td colspan="4">Belum Ada Data Terkait.</td>
														</tr>
													@endforelse
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-5 bg-blue text-white">
							<h6 class="align-middle text-right font-weight-bold p-2">Total DP : Rp. {{ number_format($pemesanan['nominal_dp'], 0, ',', '.') }}</h5>
							<h6 class="align-middle text-right font-weight-bold p-2">Total Pembayaran : Rp. {{ number_format($pemesanan['total_pembayaran'], 0, ',', '.') }}</h5>
							<h6 class="align-middle text-right font-weight-bold p-2">Nominal Yang Harus di-Bayar : Rp. {{ number_format(($pemesanan['total_pembayaran'] - $pemesanan['nominal_dp']), 0, ',', '.') }}</h5>
						</div>
						<div class="col-md-12">
							<hr>
						</div>
						<div class="col-md-5">
							<button class="btn btn-outline-success btn-block" wire:click="tambahData" wire:loading.attr="disabled">
								<span class="fa fa-check"></span> &ensp; Update Data Booking / Reservasi
							</button>
						</div>
					</div>
				</div>
        <div class="tab-pane fade" wire:ignore.self id="hasil" role="tabpanel" aria-labelledby="hasil-tab">
					<div class="row py-1 px-4">
						<div class="col-md-9">
							<div class="form-group">
								<label for="gdrive_link">Link Google Drive :</label>
								<div class="float-right">
									@if ($pemesanan['gdrive_link'] != null)
									<a href="{{ $pemesanan['gdrive_link'] }}" target="_blank">
										<span class="badge badge-info">Buka Link Google Drive</span>
									</a>
									@endif
								</div>
								<input type="text" wire:model="gdrive" name="gdrive_link" id="gdrive_link" class="form-control" placeholder="Silahkan Masukan Link Google Drive...">
							</div>
						</div>
						<div class="col-md-3">
							<label for="">&ensp;</label>
							<button type="button" class="btn btn-block btn-info" wire:click="updateLink">
								<span class="fa fa-check"></span> &ensp; Update Link Google Drive 
							</button>
						</div>
						<div class="col-md-9">
							<div class="form-group"> 
								<label for="upload_hasil_foto" wire:click="dummy()">Upload File Hasil Foto :</label>
								<div style="{{ $errors->has('upload_hasil_foto') ? 'border: 1px solid #dc3545 !important; border-radius:4px;':'' }}">
									<div class="input-group">
										<div class="custom-file">
											<input type="file" wire:model="upload_hasil_foto" class="custom-file-input" name="upload_hasil_foto" id="upload_hasil_foto">
											<label class="custom-file-label borad" id="uploadHasilFotoLabel" for="upload_hasil_foto" >{{ $upload_hasil_foto != null ? $booking['kode_booking'] : 'Silahkan Pilih File Untuk di-Upload.' }}</label>
										</div>
									</div>
								</div>
								<div class="text-danger text-xs pt-1">
									{{ $errors->first('upload_hasil_foto') }}
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<label for="">&ensp;</label>
							<button type="button" class="btn btn-block btn-info" wire:click="uploadHasil">
								<span class="fa fa-check"></span> &ensp; Upload 
							</button>
						</div>
						<div class="col-md-12">
							<hr class="my-2">
						</div>
						<div class="col-md-12">
							<div class="row">
								@forelse ($hasilFoto as $item)
									<div class="col-md-3 align-middle text-center">
										<a href="{{ asset($item['file_path']) }}" data-toggle="lightbox" data-title="{{ $item['nama_file'] }}">
											<img src="{{ asset($item['file_path']) }}" alt="" srcset="" class="img-fluid">
										</a>
										<hr>
										<button class="btn btn-secondary btn-block" wire:click="deleteFoto('{{ $item['id'] }}')">
											<span class="fa fa-trash"></span>
										</button>
									</div>
								@empty
									<div class="col-md-12">
										Belum Ada Hasil Foto.
									</div>
								@endforelse
							</div>
						</div>
					</div>
				</div>
			</div>
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