@extends('layouts.app')

@section('content')
  <title>Data Karyawan</title>
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span> Data Karyawan
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      <a href="{{ route('employees.create') }}" class="btn btn-gradient-primary d-inline-flex align-items-center">
        <i class="fa fa-plus me-2"></i> Tambah Karyawan
      </a>
      </li>
    </ul>
    </nav>
  </div>
  <x-table title="Data Karyawan" description="List semua data Karyawan">
    <thead>
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Telepon</th>
      <th>Alamat</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($employees as $employee)
    <tr>
      <td>{{ $employee->name }}</td>
      <td>{{ $employee->phone }}</td>
      <td>{{ $employee->nip }}</td>
      <td>{{ $employee->address }}</td>
      <td>
      <a href="{{ route('employees.edit', $employee->id) }}"
      class="btn btn-sm btn-warning d-inline-flex align-items-center"><i class="fa fa-edit me-2"></i>Edit</a>
      <x-confirm-button :action="route('employees.destroy', $employee->id)" method="DELETE"
      title="Hapus perusahaan ini?" text="Data akan dihapus permanen. Lanjutkan?" confirmButtonText="Ya, Hapus"
      cancelButtonText="Batal" />
      </td>
    </tr>
    @endforeach
    </tbody>
  </x-table>
@endsection