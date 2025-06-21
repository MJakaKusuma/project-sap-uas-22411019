@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  {{-- Superadmin, Manager dll bisa disesuaikan --}}
  @if(auth()->user()->role === 'superadmin')
    {{-- Konten Dashboard Admin --}}
    <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard Super Admin
    </h3>
    </div>
    <div class="row">
    <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-primary card-img-holder text-white">
      <div class="card-body">
      <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
      <h4 class="font-weight-normal mb-3">Total User <i
      class="mdi mdi-account-multiple menu-icon mdi-24px float-end"></i>
      </h4>
      <h2 class="mb-5">{{ $usersCount }} User</h2>
      <h6 class="card-text">Total User Saat ini</h6>
      </div>
    </div>
    </div>
    <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
      <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
      <h4 class="font-weight-normal mb-3">Total Perusahaan <i class="mdi mdi-domain menu-icon mdi-24px float-end"></i>
      </h4>
      <h2 class="mb-5">{{ $companiesCount }} Perusahaan</h2>
      <h6 class="card-text">Total Perusahaan Saat ini</h6>
      </div>
    </div>
    </div>
    </div>
  @elseif(auth()->user()->role === 'admin')
    {{-- Konten Dashboard Admin --}}
    <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard Admin
    </h3>
    </div>
    {{-- Konten admin lainnya --}}

  @elseif(auth()->user()->role === 'employee')
    {{-- Konten Dashboard Karyawan --}}
    <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard Karyawan
    </h3>
    </div>

    {{-- Kartu-kartu --}}
    <div class="row">
    <!-- Gaji Terakhir -->
    <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
      <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
      <h4 class="font-weight-normal mb-3">Gaji Terakhir <i class="mdi mdi-cash-multiple mdi-24px float-end"></i></h4>
      @if($latestSalary)
      <h2 class="mb-5">Rp {{ number_format($latestSalary->amount, 0, ',', '.') }}</h2>
      <h6 class="card-text">Tanggal:
      {{ \Carbon\Carbon::parse($latestSalary->payment_date)->translatedFormat('d F Y') }}
      </h6>
    @else
      <h2 class="mb-5">Rp. 0</h2>
      <h6 class="card-text">Belum Ada Data Gaji</h6>
    @endif
      </div>
    </div>
    </div>

    <!-- Sisa Cuti -->
    <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
      <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
      <h4 class="font-weight-normal mb-3">Sisa Cuti <i class="mdi mdi-calendar-clock mdi-24px float-end"></i></h4>
      <h2 class="mb-5">{{ $leaveRemaining ?? 10 }} Hari</h2>
      <h6 class="card-text">Cuti tahunan tersedia</h6>
      </div>
    </div>
    </div>

    <!-- Jumlah Slip Gaji -->
    <div class="col-md-4 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
      <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
      <h4 class="font-weight-normal mb-3">Slip Gaji Saya <i
      class="mdi mdi-credit-card-outline mdi-24px float-end"></i></h4>
      <h2 class="mb-5">{{ $salaryCount }} Slip</h2>
      <h6 class="card-text">Total diterima hingga saat ini</h6>
      </div>
    </div>
    </div>
    </div>

    {{-- Chart --}}
    <div class="row">
    <div class="col-md-7 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <h4 class="card-title">Histori Gaji Bulanan</h4>
      <canvas id="salaryChart" height="200"></canvas>
      </div>
    </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
      <h4 class="card-title">Rekap Kehadiran</h4>
      <canvas id="attendancePieChart" height="200"></canvas>
      </div>
    </div>
    </div>
    </div>
  @endif
@endsection

@section('scripts')
  @if(auth()->user()->role === 'employee')
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
    // Salary Chart
    const salaryCtx = document.getElementById('salaryChart');
    if (salaryCtx) {
    new Chart(salaryCtx.getContext('2d'), {
      type: 'line',
      data: {
      labels: {!! json_encode($salaryLabels) !!},
      datasets: [{
      label: 'Gaji (Rp)',
      data: {!! json_encode($salaryAmounts) !!},
      fill: true, // penting agar background muncul
      backgroundColor: 'rgba(255, 99, 132, 0.2)', // area di bawah garis
      borderColor: 'rgba(255, 99, 132, 1)', // garis utama
      borderWidth: 2,
      tension: 0.3,
      pointRadius: 5,
      pointHoverRadius: 7
      }]
      },
      options: {
      responsive: true,
      plugins: {
      legend: {
      display: true,
      position: 'top',
      },
      tooltip: {
      callbacks: {
        label: function (context) {
        const value = context.parsed.y;
        return `Gaji: Rp ${value.toLocaleString('id-ID')}`;
        }
      }
      },
      title: {
      display: true,
      text: 'Histori Gaji Bulanan'
      }
      },
      scales: {
      y: {
      beginAtZero: false,
      ticks: {
        callback: function (value) {
        return 'Rp ' + value.toLocaleString('id-ID');
        }
      }
      },
      x: {
      title: {
        display: true,
        text: 'Bulan'
      }
      }
      },
      elements: {
      line: {
      fill: true // tambahkan ini agar area di bawah garis muncul
      }
      }
      }
    });
    }

    // Attendance Chart
    const attendanceCtx = document.getElementById('attendancePieChart');
    if (attendanceCtx) {
    new Chart(attendanceCtx.getContext('2d'), {
      type: 'pie',
      data: {
      labels: @json($attendanceLabels),
      datasets: [{
      data: @json($attendanceCounts),
      backgroundColor: [
      'rgba(75, 192, 192, 0.6)', // Hadir
      'rgba(255, 206, 86, 0.6)', // Izin
      'rgba(255, 99, 132, 0.6)', // Sakit
      'rgba(201, 203, 207, 0.6)' // Lainnya
      ],
      borderColor: '#fff',
      borderWidth: 2
      }]
      },
      options: {
      responsive: true,
      plugins: {
      legend: {
      position: 'bottom'
      },
      title: {
      display: true,
      text: 'Statistik Kehadiran'
      },
      tooltip: {
      callbacks: {
        label: function (context) {
        const label = context.label || '';
        const value = context.parsed;
        return `${label}: ${value} hari`;
        }
      }
      }
      }
      }
    });
    }
    </script>
  @endif
@endsection