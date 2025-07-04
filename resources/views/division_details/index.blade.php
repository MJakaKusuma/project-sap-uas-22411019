@extends('layouts.app')

@section('title', 'Divisi Perusahaan')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-format-list-bulleted"></i>
    </span>
    Divisi Perusahaan
    </h3>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card mb-4">
    <div class="card-body">
    <h4 class="card-title">Tambah Relasi Divisi</h4>
    <form action="{{ route('admin.division-details.store') }}" method="POST">
      @csrf
      <div class="form-group">
      <label for="division_id">Divisi</label>
      <select name="division_id" class="form-control" required>
        @foreach($divisions as $division)
      <option value="{{ $division->id }}">{{ $division->name }}</option>
      @endforeach
      </select>
      </div>
      <div class="form-group mt-2">
      <label for="basic_salary">Gaji Pokok</label>
      <input type="number" name="basic_salary" class="form-control" required>
      </div>
      <button class="btn btn-primary mt-3" type="submit">Simpan</button>
    </form>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
    <h4 class="card-title">Daftar Divisi Perusahaan</h4>
    <div class="table-responsive">
      <table class="table table-bordered">
      <thead>
        <tr>
        <th>Nama Divisi</th>
        <th>Gaji Pokok</th>
        <th>Dibuat</th>
        <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($details as $item)
      <tr>
      <td>{{ $item->division->name }}</td>
      <td>Rp {{ number_format($item->basic_salary, 0, ',', '.') }}</td>
      <td>{{ $item->created_at->format('d M Y') }}</td>
      <td class="d-flex gap-2">
        <!-- Hapus -->
        <form action="{{ route('admin.division-details.destroy', $item->id) }}" method="POST"
        onsubmit="return confirm('Yakin ingin menghapus?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">Hapus</button>
        </form>

        <!-- Toggle Form Edit -->
        <button class="btn btn-sm btn-warning" type="button"
        onclick="document.getElementById('edit-form-{{ $item->id }}').classList.toggle('d-none')">
        Edit
        </button>
      </td>
      </tr>

      <!-- Baris Form Edit (d-none by default) -->
      <tr id="edit-form-{{ $item->id }}" class="d-none">
      <td colspan="4">
        <form action="{{ route('admin.division-details.update', $item->id) }}" method="POST"
        class="row g-2 align-items-center">
        @csrf
        @method('PUT')
        <div class="col-md-5">
        <strong>{{ $item->division->name }}</strong>
        </div>
        <div class="col-md-3">
        <input type="number" name="basic_salary" class="form-control" value="{{ $item->basic_salary }}"
        required>
        </div>
        <div class="col-md-4 d-flex gap-2">
        <button class="btn btn-success" type="submit">Simpan Perubahan</button>
        <button class="btn btn-secondary" type="button"
        onclick="document.getElementById('edit-form-{{ $item->id }}').classList.add('d-none')">
        Batal
        </button>
        </div>
        </form>
      </td>
      </tr>
      @empty
      <tr>
      <td colspan="4">Belum ada data.</td>
      </tr>
      @endforelse
      </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection