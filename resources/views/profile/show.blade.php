@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-account"></i>
    </span> Profil Saya
    </h3>
  </div>

  <div class="row">
    <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
      @if ($user->avatar)
      <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" width="120">
    @else
      <i class="mdi mdi-account-circle" style="font-size: 100px;"></i>
    @endif
      <h4>{{ $user->name }}</h4>
      <p class="text-muted mb-1">{{ ucfirst($user->role) }}</p>
      <p class="text-muted">{{ $user->divisionDetail?->division->name ?? '-' }}</p>
      <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-gradient-primary mt-2">Edit Profil</a>
      </div>
    </div>
    </div>

    <div class="col-md-8">
    <div class="card">
      <div class="card-body">
      <h4 class="card-title mb-4">Informasi Detail</h4>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Nama</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->name }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->email }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">No. Telepon</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->phone ?? '-' }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Alamat</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->address ?? '-' }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Divisi</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->divisionDetail?->division->name ?? '-' }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Jabatan</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ ucfirst($user->role) }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Perusahaan</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->company->name ?? '-' }}</p>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-4 col-form-label">Gaji Pokok</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">
          @if ($user->divisionDetail)
        Rp{{ number_format($user->divisionDetail->base_salary, 0, ',', '.') }}
      @else
        -
      @endif
        </p>
        </div>
      </div>

      <div class="row mb-0">
        <label class="col-sm-4 col-form-label">Tanggal Bergabung</label>
        <div class="col-sm-8">
        <p class="form-control-plaintext">{{ $user->created_at->format('d M Y') }}</p>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>
@endsection