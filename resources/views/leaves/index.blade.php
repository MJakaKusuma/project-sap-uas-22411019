@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-calendar-text"></i>
    </span>

    @if(auth()->user()->role === 'superadmin')
    Semua Pengajuan Cuti
    @elseif(auth()->user()->role === 'admin')
    Daftar Cuti Karyawan
    @elseif(auth()->user()->role === 'manager')
    Permintaan Cuti Tim
    @elseif(auth()->user()->role === 'employee')
    Riwayat Pengajuan Cuti Saya
    @endif
    </h3>

    @if(auth()->user()->role === 'employee')
    <a href="{{ route('employee.leaves.create') }}" class="btn btn-gradient-primary mb-3">
    <i class="fa fa-plus me-2"></i>Ajukan Cuti
    </a>
    @endif
  </div>

  <x-alert />

  <x-table title="Daftar Pengajuan Cuti" description="Data cuti sesuai peran pengguna.">
    <thead>
    <tr>
      @if(auth()->user()->role !== 'employee')
      <th>Nama</th>
      <th>Email</th>
    @endif
      <th>Tanggal Mulai</th>
      <th>Tanggal Selesai</th>
      <th>Alasan</th>
      <th>Status</th>
      @if(in_array(auth()->user()->role, ['admin', 'manager']))
      <th>Aksi</th>
    @endif
    </tr>
    </thead>
    <tbody>
    @foreach ($leaves as $leave)
    <tr>
      @if(auth()->user()->role !== 'employee')
      <td>{{ $leave->user->name }}</td>
      <td>{{ $leave->user->email }}</td>
    @endif
      <td>{{ $leave->start_date }}</td>
      <td>{{ $leave->end_date }}</td>
      <td>{{ $leave->reason }}</td>
      <td>
      <span class="badge 
      @if($leave->status == 'approved') bg-success 
    @elseif($leave->status == 'rejected') bg-danger 
    @else bg-warning text-dark @endif">
      {{ ucfirst($leave->status) }}
      </span>
      </td>
      @if(in_array(auth()->user()->role, ['admin', 'manager']))
      <td>
      @if($leave->status === 'pending')
      <form action="{{ route('admin.leaves.approve', $leave->id) }}" method="POST" class="d-inline">
      @csrf
      @method('PUT')
      <button type="submit" class="btn btn-sm btn-success">Setujui</button>
      </form>
      <form action="{{ route('admin.leaves.reject', $leave->id) }}" method="POST" class="d-inline">
      @csrf
      @method('PUT')
      <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
      </form>
    @else
      <button class="btn btn-sm btn-secondary" disabled>
      <i class="mdi mdi-check-circle-outline"></i> Sudah Disetujui/Ditolak
      </button>
    @endif
      </td>
    @endif
    </tr>
    @endforeach
    </tbody>
  </x-table>
@endsection