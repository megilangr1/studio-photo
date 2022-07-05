<div>
  <div class="row">
    <div class="col-12">
      <h6 class="font-weight-bold">
        Data Pembelian Properti
        <div class="float-right">
          <button type="button" class="btn btn-outline-secondary btn-xs px-3" wire:click="tambahProperti">
            <span class="fa fa-plus"></span> &ensp; Tambah Data Properti Pembelian
          </button>
        </div>
      </h6>
      <hr class="my-3">
    </div>
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center" width="5%">No.</th>
              <th width="20%">Nama Properti</th>
              <th width="20%">Kategori</th>
              <th width="10%">Jumlah</th>
              <th width="20%">Harga</th>
              <th width="20%">Keterangan</th>
              <th class="text-center" width="5%">#</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($dataProperti as $key => $item)
              <tr>
                <td class="align-middle text-center">{{ $loop->iteration }}.</td>
                <td>
                  <input type="text" wire:model="dataProperti.{{ $key }}.nama_properti" name="nama_properti[]" id="nama_properti_{{ $key }}" class="form-control" placeholder="Silahkan Masukan Nama Properti...">
                </td>
                <td>
                  <select wire:model="dataProperti.{{ $key }}.kategori_id" name="kategori_id[]" id="kategori_id_{{ $key }}" class="form-control {{ $errors->has('kategori_id') ? 'is-invalid':''}}" style="width: 100%;">
                    @foreach ($kategori as $item)
                      <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                    @endforeach
                  </select>
                </td>
                <td>
                  <input type="number" wire:model="dataProperti.{{ $key }}.jumlah" name="jumlah[]" id="jumlah_{{ $key }}" class="form-control" placeholder="0...">
                </td>
                <td>
                  <input type="number" wire:model="dataProperti.{{ $key }}.harga" name="harga[]" id="harga_{{ $key }}" class="form-control" placeholder="0...">
                </td>
                <td>
                  <textarea wire:model="dataProperti.{{ $key }}.keterangan" name="keterangan_properti[]" id="keterangan_properti_{{ $key }}" class="form-control" cols="1" rows="1" placeholder="Masukan Keterangan Properti..."></textarea>
                </td>
                <td class="align-middle text-center">
                  <button type="button" class="btn btn-sm btn-danger" wire:click="hapusProperti('{{ $key }}')">
                    <span class="fa fa-trash"></span>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center"> 
                  Belum Ada Data Properti.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
