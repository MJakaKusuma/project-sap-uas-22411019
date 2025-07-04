@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-account-plus"></i>
    </span>
    Tambah {{ auth()->user()->role === 'superadmin' ? 'User' : 'Karyawan' }}
    </h3>
  </div>

  {{-- Error & Session Message --}}
  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal menyimpan data!</strong>
    <ul class="mb-0 mt-1">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- FORM UNTUK SUPERADMIN --}}
  @if (auth()->user()->role === 'superadmin')
    <x-form action="{{ route('superadmin.users.store') }}" method="POST" title="Tambah User"
    description="Isi data user baru">

    <div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
    </div>

    <div class="form-group">
    <label for="role">Role</label>
    <select id="role" name="role" class="form-select" required>
      <option value="">Pilih Role</option>
      <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
      <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
    </select>
    </div>

    <div class="form-group">
    <label for="company_id">Perusahaan</label>
    <select id="company_id" name="company_id" class="form-select">
      <option value="">-- Pilih Perusahaan --</option>
      @foreach ($companies as $company)
      <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
      {{ $company->name }}
      </option>
    @endforeach
    </select>
    </div>
    </x-form>

    {{-- FORM UNTUK ADMIN --}}
  @elseif (auth()->user()->role === 'admin')
    <x-form action="{{ route('admin.users.store') }}" method="POST" title="Tambah Karyawan"
    description="Isi data karyawan baru">

    <div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
    <label for="phone">Nomor Telepon</label>
    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
    </div>

    <div class="form-group">
    <label for="address">Alamat</label>
    <textarea id="address" name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
    </div>

    <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="form-group">
    <label for="password_confirmation">Konfirmasi Password</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
    </div>

    <div class="form-group">
    <label for="role">Jabatan</label>
    <select id="role" name="role" class="form-select" required>
      <option value="">Pilih Jabatan</option>
      <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
      <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
    </select>
    </div>

    <div class="form-group">
    <label for="division_detail_id">Divisi</label>
    <select id="division_detail_id" name="division_detail_id" class="form-select">
      <option value="">-- Pilih Divisi --</option>
      @foreach ($divisions as $detail)
      <option value="{{ $detail->id }}" {{ old('division_detail_id') == $detail->id ? 'selected' : '' }}>
      {{ $detail->division->name }}
      </option>
    @endforeach
    </select>
    </div>

    </x-form>
  @endif
@endsection