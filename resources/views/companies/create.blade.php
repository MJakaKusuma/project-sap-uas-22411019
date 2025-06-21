@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span> Tambah Perusahaan
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      Form Tambah <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
    </nav>
  </div>

  <x-form action="{{ route('superadmin.companies.store') }}" method="POST" title="Tambah Perusahaan"
    description="Silakan masukkan data perusahaan baru di bawah ini.">

    <div class="form-group">
    <label for="name">Nama Perusahaan</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <div class="form-group">
    <label for="email">Email Perusahaan</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
    <label for="phonenumber">Nomor Telepon</label>
    <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="{{ old('phonenumber') }}"
      required>
    </div>

    <div class="form-group">
    <label for="address">Alamat</label>
    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
    </div>

  </x-form>
@endsection