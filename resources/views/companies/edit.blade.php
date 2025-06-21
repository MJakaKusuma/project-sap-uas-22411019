@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span> Edit Perusahaan
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      <span></span>Form Edit <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
    </nav>
  </div>

  <x-form action="{{ route('superadmin.companies.update', $company->id) }}" method="PUT" title="Edit Perusahaan"
    description="Silakan ubah data perusahaan di bawah ini.">

    <div class="form-group">
    <label for="name">Nama Perusahaan</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $company->name) }}" required>
    </div>

    <div class="form-group">
    <label for="email">Email Perusahaan</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $company->email) }}"
      required>
    </div>

    <div class="form-group">
    <label for="phonenumber">Nomor Telepon</label>
    <input type="text" class="form-control" id="phonenumber" name="phonenumber"
      value="{{ old('phonenumber', $company->phonenumber) }}" required>
    </div>

    <div class="form-group">
    <label for="address">Alamat</label>
    <textarea class="form-control" id="address" name="address"
      rows="3">{{ old('address', $company->address) }}</textarea>
    </div>

  </x-form>
@endsection