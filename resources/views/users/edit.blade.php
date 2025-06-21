@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span> Edit Karyawan
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      <span></span>Form Edit <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
    </nav>
  </div>

  <x-form action="{{ route('admin.users.update', $user->id) }}" method="PUT" title="Edit Perusahaan"
    description="Silakan ubah data perusahaan di bawah ini.">

    <div class="form-group">
    <label for="name">Nama Karyawan</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="form-group">
    <label for="email">Email Karyawan</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
    </div>

    <div class="form-group">
    <label for="phone">Nomor Telepon</label>
    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
    </div>

    <div class="form-group">
    <label for="address">Alamat</label>
    <textarea class="form-control" id="address" name="address"
      rows="3">{{ old('address', default: $user->address) }}</textarea>
    </div>
    <div class="form-group">
    <label for="divisi_id">Divisi</label>
    <select id="divisi_id" name="divisi_id" class="form-select">
      <option value="">-- Pilih Divisi --</option>
      @foreach ($divisions as $divisi)
      <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
      {{ $divisi->name }}
      </option>
    @endforeach
    </select>
    </div>
    <div class="form-group">
    <label for="role">Jabatan</label>
    <select id="role" name="role" class="form-select" required>
      <option value="">Pilih Jabatan</option>
      <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
      <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
    </select>
    </div>
  </x-form>
@endsection