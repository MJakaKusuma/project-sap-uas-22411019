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
    @php
    $pieLabels = [];
    foreach ($leaveStatusLabels as $index => $label) {
    $pieLabels[] = $label . ' (' . ($leaveStatusCounts[$index] ?? 0) . ')';
    }
    @endphp
    <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-home"></i>
    </span> Dashboard Admin
    </h3>
    </div>

    {{-- 🔹 Statistik Singkat --}}
    <div class="row">
    @php
    $summaryCards = [
    ['title' => 'Karyawan Aktif', 'count' => $employeesCount, 'icon' => 'mdi-account-multiple', 'color' => 'info'],
    ['title' => 'Cuti Diproses', 'count' => $leavePendingCount, 'icon' => 'mdi-calendar-remove', 'color' => 'danger'],
    ['title' => 'Slip Gaji Bulan Ini', 'count' => $salaryThisMonth, 'icon' => 'mdi-credit-card-outline', 'color' => 'success'],
    ];
    @endphp
    @foreach($summaryCards as $card)
    <div class="col-md-4 grid-margin stretch-card">
    <div class="card bg-gradient-{{ $card['color'] }} text-white shadow-sm">
      <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
      <h4 class="mb-2">{{ $card['title'] }}</h4>
      <i class="mdi {{ $card['icon'] }} mdi-24px"></i>
      </div>
      <h2 class="font-weight-bold">{{ $card['count'] }}</h2>
      <p class="mb-0 small">Terdaftar di perusahaan Anda</p>
      </div>
    </div>
    </div>
    @endforeach
    </div>

    {{-- 🔹 Grafik --}}
    <div class="row mt-4">
    <div class="col-md-6 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
      <h5 class="card-title mb-3">Distribusi Karyawan per Divisi</h5>
      <canvas id="employeeDivisionChart" height="180"></canvas>
      </div>
    </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
      <h5 class="card-title mb-3">Status Pengajuan Cuti</h5>
      <canvas id="leaveStatusChart" height="180"></canvas>
      </div>
    </div>
    </div>
    </div>

    <div class="row mt-3">
    <div class="col-md-12 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
      <h5 class="card-title mb-3">Slip Gaji Bulanan</h5>
      <canvas id="salaryTrendChart" height="180"></canvas>
      </div>
    </div>
    </div>
    </div>

    {{-- 🔹 Tabel Ringkas --}}
    <div class="row mt-4">
    @php
    $tables = [
    ['title' => 'Pengajuan Cuti Terakhir', 'data' => $recentLeaves, 'slot' => fn($item) => $item->user->name . ' <span class="badge bg-primary">' . ucfirst($item->status) . '</span>'],
    ['title' => 'Karyawan Terbaru', 'data' => $recentEmployees, 'slot' => fn($item) => $item->name],
    ['title' => 'Slip Gaji Terakhir', 'data' => $recentSalaries, 'slot' => fn($item) => $item->user->name . ' - Rp ' . number_format($item->amount, 0, ',', '.')],
    ];
    @endphp

    @foreach($tables as $tbl)
    <div class="col-md-4 grid-margin stretch-card">
    <div class="card shadow-sm">
      <div class="card-body">
      <h6 class="card-title mb-3">{{ $tbl['title'] }}</h6>
      <ul class="list-group list-group-flush">
      @forelse($tbl['data'] as $item)
      <li class="list-group-item d-flex justify-content-between align-items-center">
      {!! $tbl['slot']($item) !!}
      </li>
      @empty
      <li class="list-group-item text-muted">Tidak ada data.</li>
      @endforelse
      </ul>
      </div>
    </div>
    </div>
    @endforeach
    </div>


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
    @php
    $today = \Carbon\Carbon::today()->toDateString();
    $user = auth()->user();

    // Ambil status kehadiran hari ini (jika ada)
    $todayAttendance = $user->attendances()->where('date', $today)->first();
    $status = $todayAttendance->status ?? null;
    @endphp




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
  @if (auth()->user()->role === 'admin')
    {{-- Include Chart.js & ChartDataLabels --}}
    <script src="{{ asset('js/chart.js') }}"></script>
    <script
    src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>

    <script>
    // === Karyawan per Divisi (Bar) ===
    new Chart(document.getElementById('employeeDivisionChart'), {
    type: 'bar',
    data: {
      labels: @json($divisionLabels),
      datasets: [{
      label: 'Jumlah Karyawan',
      data: @json($divisionCounts),
      backgroundColor: 'rgba(54, 162, 235, 0.7)'
      }]
    },
    options: {
      responsive: true,
      plugins: {
      legend: { display: false }
      },
      scales: {
      y: {
      beginAtZero: true,
      ticks: {
      precision: 0 // Angka bulat
      }
      }
      }
    }
    });

    // === Status Pengajuan Cuti (Pie) ===
    new Chart(document.getElementById('leaveStatusChart'), {
    type: 'pie',
    data: {
      labels: @json($pieLabels),
      datasets: [{
      data: @json($leaveStatusCounts),
      backgroundColor: [
      'rgba(244, 67, 54, 0.7)',
      // disetujui
      'rgba(76, 175, 80, 0.7)',
      'rgba(255, 193, 7, 0.7)',   // diproses
      // ditolak
      ]
      }]
    },
    options: {
      responsive: true,
      plugins: {
      legend: {
      position: 'bottom',
      labels: {
      font: {
        size: 14
      }
      }
      }
      }
    }
    });
    // === Slip Gaji Bulanan (Line) ===
    new Chart(document.getElementById('salaryTrendChart'), {
    type: 'line',
    data: {
      labels: @json($salaryLabels),
      datasets: [{
      label: 'Slip Gaji Diterbitkan',
      data: @json($salaryCounts),
      fill: true,
      backgroundColor: 'rgba(153, 102, 255, 0.3)',
      borderColor: 'rgba(153, 102, 255, 1)',
      tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: {
      legend: { display: false }
      },
      scales: {
      y: {
      beginAtZero: true,
      ticks: {
      precision: 0 // Bilangan bulat
      }
      }
      }
    }
    });
    </script>
  @endif



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
      labels: @json($attendanceLabels), // ['Hadir', 'Izin', 'Sakit', 'Cuti']
      datasets: [{
      data: @json($attendanceCounts), // [jumlah_hadir, jumlah_izin, dst...]
      backgroundColor: [
      'rgba(75, 192, 192, 0.6)',   // Hadir
      'rgba(255, 206, 86, 0.6)',   // Izin
      'rgba(255, 99, 132, 0.6)',   // Sakit
      'rgba(201, 203, 207, 0.6)'   // Cuti
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
      text: 'Statistik Kehadiran Bulan Ini'
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