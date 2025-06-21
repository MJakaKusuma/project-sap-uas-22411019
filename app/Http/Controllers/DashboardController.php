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
            // Data perusahaan milik admin
            $company = $user->company;
            $employeesCount = User::where('company_id', $company->id)
                ->where('role', 'employee')
                ->count();

            // dll
            return view('dashboard.index', compact('company', 'employeesCount'));
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
            // Data personal employee
            $employee = $user->employee;
            $latestSalary = \App\Models\Salary::where('user_id', $user->id)->latest('payment_date')->first();
            $salaryHistory = Salary::where('user_id', $user->id)
                ->orderBy('payment_date', 'asc')
                ->limit(6)
                ->get();
            $attendanceStats = Attendance::where('user_id', $user->id)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');
            $salaryLabels = $salaryHistory->map(function ($salary) {
                return \Carbon\Carbon::parse($salary->payment_date)->format('M Y');
            });

            $attendanceLabels = $attendanceStats->map(function ($total, $status) {
                return ucfirst($status) . ' (' . $total . ')';
            })->values();
            $attendanceCounts = $attendanceStats->values();
            $salaryAmounts = $salaryHistory->pluck('amount');
            $salaryCount = Salary::where('user_id', $user->id)->count();
            return view('dashboard.index', compact(
                'employee',
                'latestSalary',
                'salaryLabels',
                'salaryAmounts',
                'salaryCount',
                'attendanceLabels',
                'attendanceCounts'
            ));
        }

        abort(403); // jika role tidak dikenal
    }
}