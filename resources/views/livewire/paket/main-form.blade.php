<div>
	<form action="{{ route('backend.paket.store') }}" method="post" wire:submit.prevent="buatData">
		@csrf
		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label for="nama_paket">Nama Paket :</label>
					<input type="text" wire:model="paket.nama_paket" name="nama_paket" id="nama_paket" class="form-control borad {{ $errors->has('paket.nama_paket') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pengguna..." value="{{ old('nama_paket') }}" required autofocus>
					<div class="invalid-feedback">
						{{ $errors->first('paket.nama_paket') }}
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga">Harga Paket :</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text borad font-weight-bold">Rp. </span>
						</div>
						<input type="number" wire:model="paket.harga" name="harga" id="harga" class="form-control borad {{ $errors->has('paket.harga') ? 'is-invalid':'' }}" placeholder="Masukan Harga Paket.jumlah_cetakan.." value="{{ old('harga') }}" required>
						<div class="invalid-feedback">
							{{ $errors->first('paket.harga') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="jumlah_foto">Jumlah Foto :</label>
					<div class="input-group">
						<input type="number" wire:model="paket.jumlah_foto" name="jumlah_foto" id="jumlah_foto" class="form-control borad {{ $errors->has('paket.jumlah_foto') ? 'is-invalid':'' }}" placeholder="0" value="{{ old('jumlah_foto') ?? 0}}" required>
						<div class="input-group-append">
							<span class="input-group-text borad font-weight-bold"> Foto</span>
						</div>
						<div class="invalid-feedback">
							{{ $errors->first('paket.jumlah_foto') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="durasi">Durasi Pemotretan :</label>
					<div class="input-group">
						<input type="number" wire:model="paket.durasi" name="durasi" id="durasi" class="form-control borad {{ $errors->has('paket.durasi') ? 'is-invalid':'' }}" placeholder="0" value="{{ old('durasi') ?? 0 }}" required>
						<div class="input-group-append">
							<span class="input-group-text borad font-weight-bold"> Menit</span>
						</div>
						<div class="invalid-feedback">
							{{ $errors->first('paket.durasi') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="jumlah_baju">Jumlah Baju :</label>
					<div class="input-group">
						<input type="number" wire:model="paket.jumlah_baju" name="jumlah_baju" id="jumlah_baju" class="form-control borad {{ $errors->has('paket.jumlah_baju') ? 'is-invalid':'' }}" placeholder="0" value="{{ old('jumlah_baju') ?? 0 }}" required>
						<div class="input-group-append">
							<span class="input-group-text borad font-weight-bold"> Baju</span>
						</div>
						<div class="invalid-feedback">
							{{ $errors->first('paket.jumlah_baju') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="pose">Jumlah Pose Berfoto :</label>
					<div class="input-group">
						<input type="number" wire:model="paket.pose" name="pose" id="pose" class="form-control borad {{ $errors->has('paket.pose') ? 'is-invalid':'' }}" placeholder="0" value="{{ old('pose') ?? 0 }}" required>
						<div class="input-group-append">
							<span class="input-group-text borad font-weight-bold"> Pose</span>
						</div>
						<div class="invalid-feedback">
							{{ $errors->first('paket.pose') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="harga_tambah_foto">Harga Tambah Berfoto :</label>
					<div class="input-group">
						<div class="input-group-prepend">
							<span class="input-group-text borad font-weight-bold">Rp. </span>
						</div>
						<input type="number" wire:model="paket.harga_tambah_foto" name="harga_tambah_foto" id="harga_tambah_foto" class="form-control borad {{ $errors->has('paket.harga_tambah_foto') ? 'is-invalid':'' }}" placeholder="Masukan Harga Tambah Berfoto..." value="{{ old('harga_tambah_foto') }}">
						<div class="invalid-feedback">
							{{ $errors->first('paket.harga_tambah_foto') }}
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
					<label for="informasi_tambahan">Informasi Tambahan :</label>
					<input type="text" wire:model="paket.informasi_tambahan" name="informasi_tambahan" id="informasi_tambahan" class="form-control borad {{ $errors->has('paket.informasi_tambahan') ? 'is-invalid':'' }}" placeholder="Masukan Informasi Tambahan..." value="{{ old('informasi_tambahan') }}">
					<div class="invalid-feedback">
						{{ $errors->first('paket.informasi_tambahan') }}
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="keterangan_lainnya">Keterangan Lainnya :</label>
					<textarea wire:model="paket.keterangan_lainnya" name="keterangan_lainnya" id="keterangan_lainnya" cols="1" rows="1" class="form-control borad {{ $errors->has('paket.keterangan_lainnya') }}">{{ old('keterangan_lainnya') }}</textarea>
					<div class="invalid-feedback">
						{{ $errors->first('paket.keterangan_lainnya') }}
					</div>
				</div>
			</div>
			<div class="col-12">
				<h6 class="font-weight-bold">Jumlah Hasil Cetak : </h6>
				<hr class="my-2">
			</div>
			<div class="col-12 px-3">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="30%">Jumlah Foto</th>
								<th>Ukuran Foto</th>
								<th>Keterangan</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paket['jumlah_cetakan'] as $jcKey => $jcblItem)
								<tr>
									<td>
										<div class="input-group">
											<div class="input-group">
												<input type="number" wire:model="paket.jumlah_cetakan.{{ $jcKey }}.jumlah_cetakan" name="jumlah_cetakan[]" id="jumlah_cetakan_{{ $jcKey }}" min="0" class="form-control borad {{ $errors->has('paket.jumlah_cetakan.'. $jcKey . '.jumlah_cetakan') ? 'is-invalid':'' }}" placeholder="Masukan Jumlah Cetakan Foto...">
												<div class="input-group-append">
													<span class="input-group-text borad font-weight-bold">Cetak</span>
												</div>
												<div class="invalid-feedback">
													{{ $errors->first('paket.jumlah_cetakan.'. $jcKey . '.jumlah_cetakan') }}
												</div>
											</div>
										</div>
									</td>
									<td>
										<div class="input-group">
											<div class="input-group">
												<div class="input-group-append">
													<span class="input-group-text borad font-weight-bold">
														<span class="fa fa-caret-right"></span>
													</span>
												</div>
												<input type="text" wire:model="paket.jumlah_cetakan.{{ $jcKey }}.ukuran_cetakan" name="ukuran_cetakan[]" id="ukuran_cetakan_{{ $jcKey }}" class="form-control borad {{ $errors->has('paket.jumlah_cetakan.'. $jcKey . '.ukuran_cetakan') ? 'is-invalid':'' }}" placeholder="Masukan Ukuran Cetak...">
												<div class="invalid-feedback">
													{{ $errors->first('paket.jumlah_cetakan.'. $jcKey . '.ukuran_cetakan') }}
												</div>
											</div>
										</div>
									</td>
									<td>
										<textarea wire:model="paket.jumlah_cetakan.{{ $jcKey }}.keterangan" name="keterangan_jumlah_cetakan" id="keterangan_jumlah_cetakan_{{ $jcKey }}" cols="1" rows="1" class="form-control {{ $errors->has('paket.jumlah_cetakan.'. $jcKey . '.keterangan') ? 'is-invalid':'' }}"></textarea>
										<div class="invalid-feedback">
											{{ $errors->first('paket.jumlah_cetakan.'. $jcKey . '.keterangan') }}
										</div>
									</td>
									<td class="text-center align-middle">
										<button type="button" class="btn btn-sm btn-danger borad" wire:click="hapusJumlahCetakan('{{ $jcKey }}')">
											<span class="fa fa-trash"></span>
										</button>
									</td>
								</tr>
								@endforeach
								<tr>
									<td class="align-middle text-center" colspan="3">
										<button type="button" class="btn btn-outline-secondary btn-sm" wire:click="tambahJumlahCetakan">
											<span class="fa fa-plus"></span> &ensp; Tambah Nilai Hasil Cetak 
										</button>
									</td>
									<td></td>
								</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-12">
				<h6 class="font-weight-bold">Biaya Tambahan Lainnya : </h6>
				<hr class="my-2">
			</div>
			<div class="col-12 px-3">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="30%">Biaya Tambahan Untuk</th>
								<th>Nominal Biaya</th>
								<th>Keterangan</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($paket['biaya_lainnya'] as $blKey => $blItem)
								<tr>
									<td>
										<div class="input-group">
											<div class="input-group">
												<input type="text" wire:model="paket.biaya_lainnya.{{ $blKey }}.nama_biaya" name="nama_biaya[]" id="nama_biaya_{{ $blKey }}" min="0" class="form-control borad {{ $errors->has('paket.biaya_lainnya.'. $blKey . '.nama_biaya') ? 'is-invalid':'' }}" placeholder="Masukan Nama Biaya...">
												<div class="invalid-feedback">
													{{ $errors->first('paket.biaya_lainnya.'. $blKey . '.nama_biaya') }}
												</div>
											</div>
										</div>
									</td>
									<td>
										<div class="input-group">
											<div class="input-group">
												<div class="input-group-append">
													<span class="input-group-text borad font-weight-bold">
														Rp. 
													</span>
												</div>
												<input type="number" wire:model="paket.biaya_lainnya.{{ $blKey }}.nominal_biaya" name="nominal_biaya[]" id="nominal_biaya_{{ $blKey }}" class="form-control borad {{ $errors->has('paket.biaya_lainnya.'. $blKey . '.nominal_biaya') ? 'is-invalid':'' }}" placeholder="Masukan Nominal...">
												<div class="invalid-feedback">
													{{ $errors->first('paket.biaya_lainnya.'. $blKey . '.nominal_biaya') }}
												</div>
											</div>
										</div>
									</td>
									<td>
										<textarea wire:model="paket.biaya_lainnya.{{ $blKey }}.keterangan" name="keterangan_biaya_lainnya" id="keterangan_biaya_lainnya_{{ $blKey }}" cols="1" rows="1" class="form-control {{ $errors->has('paket.biaya_lainnya.'. $blKey . '.keterangan') ? 'is-invalid':'' }}"></textarea>
										<div class="invalid-feedback">
											{{ $errors->first('paket.biaya_lainnya.'. $blKey . '.keterangan') }}
										</div>
									</td>
									<td class="text-center align-middle">
										<button type="button" class="btn btn-sm btn-danger borad" wire:click="hapusBiayaLainnya('{{ $blKey }}')">
											<span class="fa fa-trash"></span>
										</button>
									</td>
								</tr>
								@endforeach
								<tr>
									<td class="align-middle text-center" colspan="3">
										<button type="button" class="btn btn-outline-secondary btn-sm" wire:click="tambahBiayaLainnya">
											<span class="fa fa-plus"></span> &ensp; Tambah Biaya Lainnya 
										</button>
									</td>
									<td></td>
								</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-12">
				<hr class="my-2">
			</div>
			<div class="col-md-4">
				<button type="submit" class="btn btn-success btn-block">
					<span class="fa fa-check"></span> &ensp; Buat Data
				</button>
			</div>
			<div class="col-md-4">
				<button type="reset" class="btn btn-danger btn-block">
					<span class="fa fa-undo"></span> &ensp; Reset Input
				</button>
			</div>
		</div>
	</form>
</div>
