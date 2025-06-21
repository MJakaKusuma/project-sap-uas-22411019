@extends('layouts.app')

@section('title', 'Detail Gaji')

@section('content')
  <div class="container mt-4">
    <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Detail Gaji</h4>
    </div>
    <div class="card-body">
      {{-- Informasi Karyawan --}}
      <h5 class="mb-3">Informasi Karyawan</h5>
      <ul class="list-group mb-4">
      <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
      <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
      <li class="list-group-item"><strong>Perusahaan:</strong> {{ $user->employee->company->name ?? '-' }}</li>
      <li class="list-group-item"><strong>Divisi:</strong> {{ $user->employee->division->name ?? '-' }}</li>
      </ul>

      {{-- Rincian Gaji --}}
      <h5 class="mb-3">Rincian Gaji</h5>
      <table class="table table-bordered">
      <tr>
        <th>Tanggal</th>
        <td>
        {{ $salary ? \Carbon\Carbon::parse($salary->date)->format('d M Y') : 'Data Gaji Belum Tersedia' }}
        </td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>
        {{ $salary ? 'Rp' . number_format($salary->amount, 0, ',', '.') : 'Rp0' }}
        </td>
      </tr>
      </table>

      @unless ($salary)
      <p class="text-danger mt-2">Silakan hubungi admin jika ini sebuah kesalahan.</p>
    @endunless

      <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
    </div>
  </div>
@endsection