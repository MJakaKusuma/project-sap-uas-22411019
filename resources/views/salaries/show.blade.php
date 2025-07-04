@extends('layouts.app')

@section('title', 'Detail Gaji')

@section('content')
  <div class="container mt-4">
    <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Slip Gaji Karyawan</h4>
    </div>

    <div class="card-body">
      {{-- Informasi Karyawan --}}
      <h5 class="mb-3">Informasi Karyawan</h5>
      <ul class="list-group mb-4">
      <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
      <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
      <li class="list-group-item"><strong>Perusahaan:</strong> {{ $user->company->name ?? '-' }}</li>
      <li class="list-group-item"><strong>Divisi:</strong> {{ $user->divisionDetail?->division->name ?? '-' }}</li>
      </ul>

      {{-- Slip Gaji Terbaru --}}
      <h5 class="mb-3">Gaji Bulan Ini</h5>
      @if($salary)
      <table class="table table-bordered mb-4">
      <tr>
      <th>Tanggal</th>
      <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
      </tr>
      <tr>
      <th>Gaji Pokok</th>
      <td>Rp{{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Tunjangan</th>
      <td>Rp{{ number_format($salary->allowance, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Bonus</th>
      <td>Rp{{ number_format($salary->bonus, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Potongan</th>
      <td>Rp{{ number_format($salary->deduction, 0, ',', '.') }}</td>
      </tr>
      <tr class="bg-light">
      <th>Total Diterima</th>
      <td><strong>Rp{{ number_format($salary->amount, 0, ',', '.') }}</strong></td>
      </tr>
      </table>
    @else
      <p class="text-danger">Data gaji belum tersedia untuk bulan ini.</p>
    @endif

      {{-- Form Riwayat Gaji --}}
      @if($salaryHistory->count() > 1)
      <hr class="my-4">
      <h5 class="mb-3">Lihat Slip Gaji Sebelumnya</h5>
      <form method="GET" action="" class="mb-4">
      <div class="row align-items-center">
        <label for="history" class="col-sm-3 col-form-label text-end">Pilih Bulan</label>
        <div class="col-sm-6">
        <select id="history" class="form-control" onchange="window.location.href='?month=' + this.value">
        <option value="">-- Pilih Gaji Bulan --</option>
        @foreach($salaryHistory as $item)
        <option value="{{ $item->id }}" {{ request('month') == $item->id ? 'selected' : '' }}>
        {{ \Carbon\Carbon::parse($item->payment_date)->translatedFormat('F Y') }}
        </option>
      @endforeach
        </select>
        </div>
      </div>
      </form>


      {{-- Jika slip dari histori dipilih --}}
      @php
      $selected = $salaryHistory->firstWhere('id', request('month'));
      @endphp

      @if($selected && $selected->id !== $salary->id)
      <hr>
      <h5 class="mb-3">Detail Gaji Bulan {{ \Carbon\Carbon::parse($selected->payment_date)->translatedFormat('F Y') }}
      </h5>
      <table class="table table-bordered">
      <tr>
      <th>Tanggal</th>
      <td>{{ \Carbon\Carbon::parse($selected->payment_date)->format('d M Y') }}</td>
      </tr>
      <tr>
      <th>Gaji Pokok</th>
      <td>Rp{{ number_format($selected->basic_salary, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Tunjangan</th>
      <td>Rp{{ number_format($selected->allowance, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Bonus</th>
      <td>Rp{{ number_format($selected->bonus, 0, ',', '.') }}</td>
      </tr>
      <tr>
      <th>Potongan</th>
      <td>Rp{{ number_format($selected->deduction, 0, ',', '.') }}</td>
      </tr>
      <tr class="bg-light">
      <th>Total Diterima</th>
      <td><strong>Rp{{ number_format($selected->amount, 0, ',', '.') }}</strong></td>
      </tr>
      </table>
      @endif
    @endif

      <a href="{{ url()->previous() }}" class="btn btn-secondary mt-4">Kembali</a>
    </div>
    </div>
  </div>
@endsection