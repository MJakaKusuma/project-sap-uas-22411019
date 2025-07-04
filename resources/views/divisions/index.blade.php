@extends('layouts.app')

@section('title', 'Manajemen Divisi')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-domain"></i>
    </span>
    Manajemen Divisi
    </h3>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Form Superadmin: Tambah Divisi Global --}}
  @if(auth()->user()->role === 'superadmin')
    <div class="card mb-4">
    <div class="card-body">
    <h4 class="card-title">Tambah Divisi Global</h4>
    <form action="{{ route('superadmin.divisions.store') }}" method="POST">
      @csrf
      <div class="form-group">
      <label for="name">Nama Divisi</label>
      <input type="text" name="name" class="form-control" required>
      </div>
      <button class="btn btn-primary mt-2" type="submit">Simpan</button>
    </form>
    </div>
    </div>
  @endif

  {{-- Form Admin: Tambah Relasi Divisi + Gaji --}}
  @if(auth()->user()->role === 'admin')
    <div class="card mb-4">
    <div class="card-body">
    <h4 class="card-title">Tambah Detail Divisi (Perusahaan Anda)</h4>
    <form action="{{ route('admin.divisionDetails.store') }}" method="POST">
      @csrf
      <div class="form-group">
      <label for="division_id">Divisi</label>
      <select name="division_id" class="form-control" required>
      @foreach($divisions as $division)
      <option value="{{ $division->id }}">{{ $division->name }}</option>
      @endforeach
      </select>
      </div>
      <div class="form-group">
      <label for="basic_salary">Gaji Pokok</label>
      <input type="number" name="basic_salary" class="form-control" required>
      </div>
      <button class="btn btn-success mt-2" type="submit">Tambah Relasi Divisi</button>
    </form>
    </div>
    </div>
  @endif

  {{-- Tabel Daftar --}}
  <div class="card">
    <div class="card-body">
    <h4 class="card-title">Daftar Divisi</h4>
    <div class="table-responsive">
      <table class="table table-bordered">
      <thead>
        <tr>
        <th>Nama Divisi</th>
        @if(auth()->user()->role === 'admin')
      <th>Gaji Pokok</th> @endif
        <th>Dibuat</th>
        </tr>
      </thead>
      <tbody>
        @forelse($list as $item)
        <tr>
        <td>{{ $item->name }}</td>
        @if(auth()->user()->role === 'admin')
      <td>Rp {{ number_format($item->basic_salary, 0, ',', '.') }}</td>
      @endif
        <td>{{ $item->created_at->format('d M Y') }}</td>
        </tr>
      @empty
      <tr>
      <td colspan="{{ auth()->user()->role === 'admin' ? 3 : 2 }}">Belum ada data.</td>
      </tr>
      @endforelse
      </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection