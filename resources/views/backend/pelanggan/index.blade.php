@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-pelanggan text-primary"></span> &ensp; Data Pelanggan</h5>
        <div class="card-tools">
          <a href="{{ route('backend.pelanggan.create') }}" class="btn btn-xs btn-primary px-2">
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
                    <th>Nama Pelanggan</th>
                    <th>E-Mail</th>
                    <th>No. Hp</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($pelanggan as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($pelanggan->currentpage()-1) * $pelanggan->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ $item->nama_lengkap }}</td>
                      <td class="align-middle">{{ $item->user->email }}</td>
                      <td class="align-middle">{{ $item->nomor_hp }}</td>
                      </td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                          <a href="{{ route('backend.pelanggan.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                            <span class="fa fa-edit"></span>
                          </a>
                          @if (auth()->user()->id != $item->id)
                          <form action="{{ route('backend.pelanggan.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm {{ $item->deleted_at != null ? 'btn-info':'btn-danger' }} borad">
                              <span class="fa {{ $item->deleted_at != null ? 'fa-undo':'fa-trash' }}"></span>
                            </button>
                          </form>
                          @endif
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="align-middle text-center">Belum Ada Data Akun BMD.</td>
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
              {{ $pelanggan->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection