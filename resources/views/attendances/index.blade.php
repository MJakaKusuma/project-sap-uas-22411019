@extends('layouts.app')

@section('title', 'Rekap Kehadiran')

@section('content')
  @php
    use Carbon\Carbon;
    $today = Carbon::now()->toDateString();
    @endphp

  <div class="container mt-4">
    <div class="row mb-4">
    {{-- Rekap Harian --}}
    <div class="col-md-12">
      <div class="card shadow-sm">
      <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="mdi mdi-calendar-check me-2"></i>Rekap Kehadiran Hari Ini
        ({{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }})</h5>
      </div>
      <div class="card-body">
        <div class="row text-center">
        @php
      $statusList = ['hadir' => 'success', 'cuti' => 'info', 'izin' => 'warning', 'sakit' => 'danger'];
      $dailySummary = [];

      foreach ($statusList as $status => $color) {
        $dailySummary[$status] = $users->sum(fn($u) => $u->attendances->where('date', $today)->where('status', $status)->count());
      }

      $withoutStatus = $users->sum(fn($u) => $u->attendances->where('date', $today)->whereNull('status')->count());
      @endphp

        @foreach ($statusList as $status => $color)
      <div class="col-md-2 col-6 mb-3">
        <div class="border rounded py-2 bg-light">
        <h6 class="text-{{ $color }} mb-1 text-capitalize">{{ $status }}</h6>
        <span class="badge bg-{{ $color }} fs-6">{{ $dailySummary[$status] }}</span>
        </div>
      </div>
      @endforeach

        <div class="col-md-2 col-6 mb-3">
          <div class="border rounded py-2 bg-light">
          <h6 class="text-muted mb-1">Alpa</h6>
          <span class="badge bg-secondary fs-6">{{ $withoutStatus }}</span>
          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>

    {{-- Rekap Bulanan --}}
    <div class="card shadow-sm">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="mdi mdi-calendar-month me-2"></i>Rekap Bulan
      {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
      </h5>
    </div>

    <div class="card-body table-responsive">
      <table class="table table-bordered table-hover align-middle">
      <thead class="table-primary">
        <tr class="text-center">
        <th>Nama</th>
        <th>Hadir</th>
        <th>Cuti</th>
        <th>Izin</th>
        <th>Sakit</th>
        <th>Alpa</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $user)
        @php
      $hadir = $user->attendances->where('status', 'hadir')->count();
      $cuti = $user->attendances->where('status', 'cuti')->count();
      $izin = $user->attendances->where('status', 'izin')->count();
      $sakit = $user->attendances->where('status', 'sakit')->count();
      $alpa = $user->attendances->where('status', 'alpa')->count();
      @endphp
        <tr class="text-center">
        <td class="text-start">
        <div class="d-flex align-items-center gap-2">
        @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" width="32" height="32"
        style="object-fit: cover;">
      @else
        <i class="mdi mdi-account-circle text-muted" style="font-size: 32px;"></i>
      @endif
        <span>{{ $user->name }}</span>
        </div>
        </td>
        <td><span class="badge bg-success">{{ $hadir }}</span></td>
        <td><span class="badge bg-info">{{ $cuti }}</span></td>
        <td><span class="badge bg-warning text-dark">{{ $izin }}</span></td>
        <td><span class="badge bg-danger">{{ $sakit }}</span></td>
        <td><span class="badge bg-secondary">{{ $alpa }}</span></td>
        </tr>
      @empty
      <tr>
      <td colspan="6" class="text-center text-muted">Tidak ada data kehadiran untuk bulan ini.</td>
      </tr>
      @endforelse
      </tbody>
      </table>
    </div>
    </div>
    @if(auth()->user()->role === 'admin')
    <div class="card shadow-sm mt-5">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0"><i class="mdi mdi-pencil-box-multiple me-2"></i>Input Kehadiran Manual</h5>
    </div>

    <div class="card-body">
      <form action="{{ route('admin.attendances.store') }}" method="POST" class="row g-3 align-items-end">
      @csrf

      {{-- Pilih User --}}
      <div class="col-md-4">
      <label class="form-label fw-semibold">Nama Karyawan</label>
      <select name="user_id" class="form-select shadow-sm" required>
      <option value="">-- Pilih Karyawan --</option>
      @foreach($users as $u)
      <option value="{{ $u->id }}">{{ $u->name }}</option>
      @endforeach
      </select>
      </div>

      {{-- Tanggal --}}
      <div class="col-md-3">
      <label class="form-label fw-semibold">Tanggal</label>
      <input type="date" name="date" class="form-control shadow-sm"
      value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
      </div>

      {{-- Status --}}
      <div class="col-md-3">
      <label class="form-label fw-semibold">Status Kehadiran</label>
      <select name="status" class="form-select shadow-sm" required>
      <option value="">-- Pilih Status --</option>
      <option value="hadir">Hadir</option>
      <option value="cuti">Cuti</option>
      <option value="izin">Izin</option>
      <option value="sakit">Sakit</option>
      <option value="alpa">Alpa</option>
      </select>
      </div>

      {{-- Tombol Submit --}}
      <div class="col-md-2 d-grid">
      <button type="submit" class="btn btn-gradient-primary shadow-sm">
      <i class="mdi mdi-check-circle-outline me-1"></i> Simpan
      </button>
      </div>
      </form>
    </div>
    </div>
    @endif

  </div>
@endsection