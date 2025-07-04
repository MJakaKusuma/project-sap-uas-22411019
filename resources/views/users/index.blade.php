@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
  @php $role = auth()->user()->role; @endphp

  @if($role === 'superadmin')
    {{-- === SUPERADMIN VIEW === --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h3 class="page-title d-flex align-items-center mb-2 mb-md-0">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-account-multiple"></i>
    </span>
    Daftar Users
    </h3>

    <div class="d-flex align-items-center gap-2">
    {{-- Filter --}}
    <div class="dropdown">
      <button class="btn btn-gradient-primary dropdown-toggle" type="button" id="dropdownFilterButton"
      data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa fa-filter me-1"></i> Filter
      </button>
      <div class="dropdown-menu p-3" style="min-width: 300px">
      <form method="GET">
      <div class="mb-2">
      <label class="form-label">Cari Nama / Email</label>
      <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari...">
      </div>

      <div class="mb-2">
      <label class="form-label">Role</label>
      <select name="role" class="form-select">
        <option value="">Semua</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
      </select>
      </div>

      <div class="mb-2">
      <label class="form-label">Urutkan Berdasarkan</label>
      <select name="sort_by" class="form-select">
        <option value="">Default</option>
        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
        <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
      </select>
      </div>

      <div class="mb-2">
      <label class="form-label">Arah</label>
      <select name="order" class="form-select">
        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z</option>
        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A</option>
      </select>
      </div>

      <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">
      <i class="fa fa-search me-1"></i> Terapkan Filter
      </button>
      </form>
      </div>
    </div>

    {{-- Tombol Tambah --}}
    <a href="{{ route('superadmin.users.create') }}" class="btn btn-gradient-primary">
      <i class="fa fa-plus me-1"></i> Tambah User
    </a>
    </div>
    </div>

    {{-- Table --}}
    <x-table title="List Users" description="Daftar semua user sistem">
    <thead>
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Perusahaan</th>
      <th>Role</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($users as $user)
    <tr>
      <td>
      <div class="d-flex align-items-center gap-2">
      @if ($user->avatar)
      <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="rounded-circle" width="32" height="32"
      style="object-fit: cover;">
      @else
      <i class="mdi mdi-account-circle text-muted" style="font-size: 32px;"></i>
      @endif
      <span class="">{{ $user->name }}</span>
      </div>
      </td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->company->name ?? '-' }}</td>
      <td>{{ ucfirst($user->role) }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
    </tr>
    @endforelse
    </tbody>
    </x-table>

  @elseif($role === 'admin')
    {{-- === ADMIN VIEW === --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h3 class="page-title d-flex align-items-center mb-2 mb-md-0">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-account-multiple"></i>
    </span>
    Daftar Karyawan
    </h3>

    <div class="d-flex align-items-center gap-2">
    {{-- Filter --}}
    <div class="dropdown">
      <button class="btn btn-gradient-primary dropdown-toggle" type="button" id="dropdownFilterButton"
      data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fa fa-filter me-1"></i> Filter
      </button>
      <div class="dropdown-menu p-3" style="min-width: 300px">
      <form method="GET">
      <div class="mb-2">
      <label class="form-label">Cari Nama / Email</label>
      <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Cari...">
      </div>

      <div class="mb-2">
      <label class="form-label">Role</label>
      <select name="role" class="form-select">
        <option value="">Semua</option>
        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
        <option value="employee" {{ request('role') == 'employee' ? 'selected' : '' }}>Employee</option>
      </select>
      </div>

      <div class="mb-2">
      <label class="form-label">Urutkan Berdasarkan</label>
      <select name="sort_by" class="form-select">
        <option value="">Default</option>
        <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
        <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
      </select>
      </div>

      <div class="mb-2">
      <label class="form-label">Arah</label>
      <select name="order" class="form-select">
        <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>A-Z</option>
        <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Z-A</option>
      </select>
      </div>

      <button type="submit" class="btn btn-sm btn-primary w-100 mt-2">
      <i class="fa fa-search me-1"></i> Terapkan Filter
      </button>
      </form>
      </div>
    </div>

    {{-- Tombol Tambah --}}
    <a href="{{ route('admin.users.create') }}" class="btn btn-gradient-primary">
      <i class="fa fa-plus me-1"></i> Tambah Karyawan
    </a>
    </div>
    </div>

    {{-- Table --}}
    <x-table title="List Karyawan dan Manajer" description="Daftar semua karyawan dan manajer di perusahaan Anda">
    <thead>
    <tr>
      <th>Nama</th>
      <th>Email</th>
      <th>Telepon</th>
      <th>Alamat</th>
      <th>Divisi</th>
      <th>Jabatan</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($users as $user)
    <tr>
      <td>
      <div class="d-flex align-items-center gap-2">
      @if ($user->avatar)
      <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" class="rounded-circle" width="32" height="32"
      style="object-fit: cover;">
      @else
      <i class="mdi mdi-account-circle text-muted" style="font-size: 32px;"></i>
      @endif
      <span class="">{{ $user->name }}</span>
      </div>
      </td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->phone }}</td>
      <td>
      <div class="text-truncate" style="max-width: 100px;">{{ $user->address }}</div>
      </td>
      <td>{{ $user->divisionDetail?->division->name ?? '-' }}</td>
      <td>{{ ucfirst($user->role) }}</td>
      <td class="d-flex gap-2">
      <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
      <i class="fa fa-edit me-1"></i> Edit
      </a>
      <x-confirm-button :action="route('admin.users.destroy', $user->id)" method="DELETE" title="Hapus user ini?"
      text="Data akan dihapus permanen. Lanjutkan?" confirmButtonText="Ya, Hapus" cancelButtonText="Batal"
      class="btn btn-sm btn-danger" />
      </td>
    </tr>
    @empty
    <tr>
      <td colspan="7" class="text-center">Tidak ada data ditemukan.</td>
    </tr>
    @endforelse
    </tbody>
    </x-table>
  @endif

  {{-- Pagination --}}
  <div class="d-flex justify-content-center mt-4">
    {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
  </div>
@endsection