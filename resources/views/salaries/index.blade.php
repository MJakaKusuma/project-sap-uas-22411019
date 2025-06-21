<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaji Karyawan</title>
</head>

<body>
  @extends('layouts.app')
  @section('title', 'Data Gaji Karyawan')

  @section('content')
    @if(auth()->user()->role === 'admin')
    <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-cash-multiple"></i>
      </span> Data Gaji Karyawan
    </h3>

    <a href="{{ route('admin.salaries.create') }}" class="btn btn-gradient-primary mb-3">
      <i class="fa fa-plus me-2"></i>Tambah Gaji
    </a>
    </div>

    <x-table title="List Gaji Karyawan" description="Daftar seluruh riwayat gaji yang sudah diinput">
    <thead>
      <tr>
      <th>Nama</th>
      <th>Divisi</th>
      <th>Gaji Pokok</th>
      <th>Tunjangan</th>
      <th>Bonus</th>
      <th>Potongan</th>
      <th>Total Dibayar</th>
      <th>Tanggal</th>
      <th>Status</th>
      <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($salaries as $salary)
      <tr>
      <td>{{ $salary->user->name }}</td>
      <td>{{ $salary->user->division->name ?? '-' }}</td>
      <td>Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
      <td>Rp {{ number_format($salary->allowance, 0, ',', '.') }}</td>
      <td>Rp {{ number_format($salary->bonus, 0, ',', '.') }}</td>
      <td>Rp {{ number_format($salary->deduction, 0, ',', '.') }}</td>
      <td><strong>Rp {{ number_format($salary->amount, 0, ',', '.') }}</strong></td>
      <td>{{ \Carbon\Carbon::parse($salary->payment_date)->format('d M Y') }}</td>
      <td>
      @if($salary->payment_status === 'paid')
      <span class="badge badge-gradient-success">Dibayar</span>
      @else
      <span class="badge badge-gradient-warning">Pending</span>
      @endif
      </td>
      <td>
      <form action="{{ route('salaries.toggleStatus', $salary->id) }}" method="POST"
      onsubmit="return confirm('Ubah status pembayaran?')">
      @csrf
      @method('PATCH')
      @if($salary->payment_status === 'pending')
      <button type="submit" class="btn btn-sm btn-success">
      <i class="mdi mdi-check"></i> Tandai Dibayar
      </button>
      @else
      <small class="text-muted">-</small>
      @endif
      </form>
      </td>
      </tr>
    @endforeach
    </tbody>
    </x-table>
    @endif
  @endsection

</body>

</html>