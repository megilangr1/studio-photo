<div>
	<div class="modal fade" wire:ignore.self id="modal-data-pelanggan">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Pilih Data Pelanggan</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body p-0">
					<div class="row">
						<div class="col-12 p-3">
							<div class="input-group input-group-sm">
								<input wire:model.debounce.700ms="search_data" class="form-control" type="search" placeholder="Masukan Detail Untuk Melakukan Pencarian..." aria-label="Search" style="border-radius: 0px !important;">
								<div class="input-group-append"> 
									<button type="button" class="btn btn-navbar px-4" wire:click="getMainPelanggan">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
						</div>
						<div wire:loading wire:target="search_data">
							<div class="col-12 px-3">
								Melakukan Pencarian Data...
							</div>
						</div>
						<div wire:loading wire:target="getMainPelanggan">
							<div class="col-12 px-3">
								Melakukan Pencarian Data...
							</div>
						</div>
					</div>
					<div class="card-body table-responsive p-0" style="height: 200px;"> 
						<table class="table table-head-fixed text-nowrap" >
							<thead>
								<tr>
									<th class="text-center" width="5%">No.</th>
									<th>Nama Pelanggan</th>
									<th>E-Mail</th>
									<th>Nomor Hp</th>
									<th class="text-center" width="10%">Aksi</th>
								</tr>
							</thead>
							<tbody id="skpd-data">
								@php $no = 1; @endphp
								@forelse ($dataPelanggan as $item)
									<tr>
										<td class="align-middle text-center">{{ $no }}.</td>
										<td class="align-middle">{{ $item->nama_lengkap }}</td> 
										<td class="align-middle">{{ $item->email }}</td> 
										<td class="align-middle">{{ $item->nomor_hp }}</td> 
										<td class="align-middle text-center">
											<div class="btn-group">
												<button type="button" class="btn btn-success btn-sm" wire:click="selectPelanggan('{{ $item->id }}')">
													<span class="fa fa-check"></span> &ensp; Pilih Pelanggan
												</button>
											</div>
										</td>
									</tr>
									@php
										$no++;
									@endphp
								@empty
									<tr>
										<td colspan="5" class="text-center align-middle">
											Belum Ada Data Pelanggan.
										</td>
									</tr>
								@endforelse
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="float-right px-4">
								{{ $dataPelanggan->links() }}
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer float-right">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup Modal</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

@push('script')
<script>
	$(document).ready(function() { 
		Livewire.on('close-modal-skpd', function() {
			$('#modal-data-pelanggan').modal('hide');
		});
	});
</script>
@endpush