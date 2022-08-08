@extends('backend.layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h5 class="card-title"> <span class="fa fa-users text-primary"></span> &ensp; Data Pengguna</h5>
        <div class="card-tools">
          <a href="{{ route('backend.user.create') }}" class="btn btn-xs btn-primary px-2">
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
                    <th>Nama Pengguna</th>
                    <th>E-Mail</th>
                    <th>Jenis User</th>
                    <th class="text-center" width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($users as $item)
                    <tr>
                      <td class="align-middle text-center">{{ ($users->currentpage()-1) * $users->perpage() + $loop->index + 1 }}.</td>
                      <td class="align-middle">{{ $item->name }}</td>
                      <td class="align-middle">{{ $item->email }}</td>
                      <td class="align-middle">
                        <ul class="m-0">
                          @foreach ($item->roles()->pluck('name') as $roles)
                            <li>
                              {{ $roles }}
                            </li>
                          @endforeach
                        </ul>
                      </td>
                      <td class="align-middle text-center">
                        <div class="btn-group">
                          @if ($item->email != 'admin@mail.com')
                            @if (in_array('Owner', auth()->user()->roles()->pluck('name')->toArray()))
                              <a href="{{ route('backend.user.permission', $item->id) }}" class="btn btn-sm btn-info borad">
                                <span class="fa fa-key"></span>
                              </a>
                            @endif
                          @endif
                          <a href="{{ route('backend.user.edit', $item->id) }}" class="btn btn-sm btn-warning borad">
                            <span class="fa fa-edit"></span>
                          </a>
                          @if (auth()->user()->id != $item->id)
                          <form action="{{ route('backend.user.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger borad">
                              <span class="fa fa-trash"></span>
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
              {{ $users->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection