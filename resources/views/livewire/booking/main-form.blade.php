<div>
  <div class="row">
    <div class="col-md-5">
      <div class="form-group">
        <label for="nama_pemesan">Nama Pemesan : </label>
        <input type="text" wire:model="pemesanan.nama_pemesan" name="nama_pemesan" id="nama_pemesan" class="form-control {{ $errors->has('nama_pemesan') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pemesan..." required autofocus>
        <div class="invalid-feedback">
          {{ $errors->first('nama_pemesan') }}
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="form-group" wire:ignore>
        <label for="paket">Paket : </label>
        <select name="paket" id="paket" class="form-control" data-placeholder="Pilih Paket Foto" style="width: 100%;">
          <option value=""></option>
          @foreach ($dataPaket as $item)
            <option value="{{ $item['id'] }}">{{ $item['nama_paket'] }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">
          {{ $errors->first('jam') }}
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-group">
        <label for="durasi">Durasi Paket : </label>
        <div class="input-group">
          @if ($paket != null)
            <input type="text" wire:model="paket.durasi" name="durasi" id="durasi" class="form-control {{ $errors->has('durasi') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pemesan..." required disabled>
          @else
            <input type="text" name="durasi" id="durasi" class="form-control {{ $errors->has('durasi') ? 'is-invalid':'' }}" placeholder="Masukan Nama Pemesan..." value="0" disabled>
          @endif
          <div class="input-group-append">
            <span class="input-group-text">
              Menit
            </span>
          </div>
        </div>
        <div class="invalid-feedback">
          {{ $errors->first('durasi') }}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="tanggal_booking" wire:click="getFreeTime('2022-07-13')">Tanggal Booking : </label>
        <input type="date" wire:model="pemesanan.tanggal_booking" name="tanggal_booking" id="tanggal_booking" class="form-control {{ $errors->has('tanggal_booking') ? 'is-invalid':'' }}" required >
        <div class="invalid-feedback">
          {{ $errors->first('tanggal_booking') }}
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group" wire:ignore>
        <label for="jam">Jam : </label>
        <select name="jam" id="jam" class="form-control" data-placeholder="Pilih Jam Pemesanan" style="width: 100%;">
          <option value=""></option>
          @foreach ($jam as $item)
            <option value="{{ $item }}">{{ $item }}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">
          {{ $errors->first('jam') }}
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
      console.log(value);

      Livewire.emit('setPaket', value);
    });

    Livewire.on('resetJam', function() {
      $('#jam').val('').trigger('change');
    });
  });
</script>
@endpush