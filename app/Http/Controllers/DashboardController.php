<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Salary;
use App\Models\Attendance;
use App\Models\Company;


class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            // Data global seluruh perusahaan, user, dll
            $companiesCount = Company::count();
            $usersCount = User::count();
            return view('dashboard.index', compact('companiesCount', 'usersCount'));
        }

        if ($user->role === 'admin') {
            $company = $user->company;

            // Jumlah karyawan di perusahaan
            $employeesCount = User::where('company_id', $company->id)
                ->where('role', 'employee')
                ->count();

            // Pengajuan cuti status pending
            $leavePendingCount = Leave::whereHas('user', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'pending')->count();

            // Slip gaji yang diterbitkan bulan ini
            $salaryThisMonth = Salary::whereHas('user', function ($q) use ($company) {
                $q->where('company_id', $company->id);
            })->whereMonth('payment_date', now()->month)->count();

            // ✅ Grafik: Distribusi Karyawan per Divisi
            $divisionData = $company->divisionDetails()->withCount([
                'users' => function ($q) {
                    $q->where('role', 'employee');
                }
            ])->get();

            $divisionLabels = $divisionData->map(fn($d) => $d->division->name);
            $divisionCounts = $divisionData->map(fn($d) => $d->users_count);

            // ✅ Grafik: Status Pengajuan Cuti
            $leaveStatusStats = Leave::whereHas('user', fn($q) => $q->where('company_id', $company->id))
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $leaveStatusLabels = $leaveStatusStats->keys();
            $leaveStatusCounts = $leaveStatusStats->values();

            // ✅ Grafik: Slip Gaji Bulanan (6 bulan terakhir)
            $salaryHistory = Salary::whereHas('user', fn($q) => $q->where('company_id', $company->id))
                ->selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as month, COUNT(*) as total")
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->take(6)
                ->get();

            $salaryLabels = $salaryHistory->pluck('month')->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->translatedFormat('M Y'));
            $salaryCounts = $salaryHistory->pluck('total');

            // ✅ Tabel: 5 cuti terakhir
            $recentLeaves = Leave::with('user')
                ->whereHas('user', fn($q) => $q->where('company_id', $company->id))
                ->latest()->take(5)->get();

            // ✅ Tabel: 5 karyawan baru
            $recentEmployees = User::where('company_id', $company->id)
                ->where('role', 'employee')
                ->latest()->take(5)->get();

            // ✅ Tabel: 5 slip gaji terakhir
            $recentSalaries = Salary::with('user')
                ->whereHas('user', fn($q) => $q->where('company_id', $company->id))
                ->latest()->take(5)->get();

            return view('dashboard.index', compact(
                'company',
                'employeesCount',
                'leavePendingCount',
                'salaryThisMonth',
                'divisionLabels',
                'divisionCounts',
                'leaveStatusLabels',
                'leaveStatusCounts',
                'salaryLabels',
                'salaryCounts',
                'recentLeaves',
                'recentEmployees',
                'recentSalaries'
            ));
        }


        if ($user->role === 'manager') {
            // Data divisi milik manager
            $division = $user->division;
            $employeesCount = User::where('division_id', $division->id)
                ->where('role', 'employee')
                ->count();

            // dll
            return view('dashboard.index', compact('division', 'employeesCount'));
        }

        if ($user->role === 'employee') {
            $employee = $user->employee;

            $latestSalary = Salary::where('user_id', $user->id)->latest('payment_date')->first();
            $salaryHistory = Salary::where('user_id', $user->id)
                ->orderBy('payment_date', 'asc')
                ->limit(6)
                ->get();

            $salaryLabels = $salaryHistory->map(function ($salary) {
                return \Carbon\Carbon::parse($salary->payment_date)->format('M Y');
            });
            $salaryAmounts = $salaryHistory->pluck('amount');
            $salaryCount = Salary::where('user_id', $user->id)->count();

            $attendanceStats = Attendance::where('user_id', $user->id)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $attendanceLabels = $attendanceStats->map(function ($total, $status) {
                return ucfirst($status) . ' (' . $total . ')';
            })->values();
            $attendanceCounts = $attendanceStats->values();

            // ✅ Hitung sisa cuti tahunan
            $limitPerYear = 12;

            $usedLeaveDays = Leave::where('user_id', $user->id)
                ->where('status', 'approved')
                ->whereYear('start_date', now()->year)
                ->get()
                ->sum(function ($leave) {
                    return \Carbon\Carbon::parse($leave->start_date)
                        ->diffInDaysFiltered(fn($date) => $date->isWeekday(), $leave->end_date) + 1;
                });

            $leaveRemaining = max($limitPerYear - $usedLeaveDays, 0);

            return view('dashboard.index', compact(
                'employee',
                'latestSalary',
                'salaryLabels',
                'salaryAmounts',
                'salaryCount',
                'attendanceLabels',
                'attendanceCounts',
                'leaveRemaining' // ← tambahkan ini
            ));
        }


        abort(403); // jika role tidak dikenal
    }
}