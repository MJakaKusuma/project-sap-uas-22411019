@extends('layouts.app')

@section('content')
  <title>Data Perusahaan</title>
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span> Data Perusahaan
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      <a href="{{ route('superadmin.companies.create') }}"
        class="btn btn-gradient-primary d-inline-flex align-items-center">
        <i class="fa fa-plus me-2"></i> Tambah Perusahaan
      </a>
      </li>
    </ul>
    </nav>
  </div>
  <x-table title="Daftar Perusahaan" description="List semua data perusahaan">
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
    @foreach ($companies as $company)
    <tr>
      <td>{{ $company->name }}</td>
      <td>{{ $company->email }}</td>
      <td>{{ $company->phonenumber }}</td>
      <td>{{ $company->address }}</td>
      <td>
      <a href="{{ route('superadmin.companies.edit', $company->id) }}"
      class="btn btn-sm btn-warning d-inline-flex align-items-center"><i class="fa fa-edit me-2"></i>Edit</a>
      <x-confirm-button :action="route('superadmin.companies.destroy', $company->id)" method="DELETE"
      title="Hapus perusahaan ini?" text="Data akan dihapus permanen. Lanjutkan?" confirmButtonText="Ya, Hapus"
      cancelButtonText="Batal" />
      </td>
    </tr>
    @endforeach
    </tbody>
  </x-table>
@endsection