@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title"><i class="mdi mdi-account-edit"></i> Edit Profil</h3>
  </div>

  <x-form action="{{ route('profile.update') }}" method="PUT" enctype="multipart/form-data" title="Edit Profil"
    description="Perbarui data profil Anda.">
    <div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
    </div>

    <div class="form-group">
    <label>Telepon</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
    </div>

    <div class="form-group">
    <label>Alamat</label>
    <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
    </div>

    <div class="form-group">
    <label>Ganti Password (opsional)</label>
    <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
    <label>Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="form-control">
    </div>

    <div class="form-group">
    <label>Avatar</label>
    <input type="file" name="avatar" class="form-control">
    @if($user->avatar)
    <small>Avatar saat ini: <img src="{{ asset('storage/' . $user->avatar) }}" height="40"></small>
    @endif
    </div>
  </x-form>
@endsection