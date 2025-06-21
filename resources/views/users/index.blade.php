@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-account-multiple"></i>
      @if(auth()->user()->role === 'superadmin')
      </span> Daftar Users
      </h3>
      <a href="{{ route('superadmin.users.create') }}" class="btn btn-gradient-primary mb-3">
      <i class="fa fa-plus me-2"></i>Tambah User
      </a>
    </div>
    <x-table title="List Users" description="Daftar semua user sistem">
      <thead>
      <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Perusahaan</th>
      <th>Role</th>
      </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
      <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->company ? $user->company->name : '-' }}</td>
      <td>{{ ucfirst($user->role) }}</td>
      </tr>
      @endforeach
      </tbody>
    </x-table>
    @endif
  @if(auth()->user()->role === 'admin')
    </span> Daftar Karyawan
    </h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-gradient-primary mb-3">
    <i class="fa fa-plus me-2"></i>Tambah Karyawan
    </a>
    </div>
    <x-table title="List Karyawan Dan Manajer" description="Daftar semua Karyawan">
    <thead>
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Nomor Telepon</th>
      <th>Alamat</th>
      <th>Divisi</th>
      <th>Jabatan</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->phone }}</td>
      <td>{{ $user->address }}</td>
      <td>{{ $user->division ? $user->division->name : '-'  }}</td>
      <td>{{ ucfirst($user->role) }}</td>
      <td><a href="{{ route('admin.users.edit', $user->id) }}"
      class="btn btn-sm btn-warning d-inline-flex align-items-center"><i class="fa fa-edit me-2"></i>Edit</a>
      <x-confirm-button :action="route('admin.users.destroy', $user->id)" method="DELETE"
      title="Hapus perusahaan ini?" text="Data akan dihapus permanen. Lanjutkan?" confirmButtonText="Ya, Hapus"
      cancelButtonText="Batal" />
      </td>
    </tr>
    @endforeach
    </tbody>
    </x-table>
  @endif
@endsection