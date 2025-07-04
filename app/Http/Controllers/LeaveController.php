<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $leaves = Leave::with('user')
                ->whereHas('user', fn($q) => $q->where('company_id', $user->company_id))
                ->latest()->get();
        } elseif ($user->role === 'employee') {
            $leaves = Leave::with('user')->where('user_id', $user->id)->latest()->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $this->authorizeRole('employee');
        return view('leaves.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('employee');

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $startDate = \Carbon\Carbon::parse($request->start_date);
        $endDate = \Carbon\Carbon::parse($request->end_date);

        // Hitung hari kerja (tanpa Sabtu & Minggu)
        $daysRequested = $startDate->diffInDaysFiltered(function ($date) {
            return $date->isWeekday();
        }, $endDate) + 1;

        // Hitung total cuti yang sudah diambil (disetujui) tahun ini
        $usedLeaveDays = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->get()
            ->sum(function ($leave) {
                return \Carbon\Carbon::parse($leave->start_date)
                    ->diffInDaysFiltered(fn($date) => $date->isWeekday(), $leave->end_date) + 1;
            });

        $limitPerYear = 12;

        if (($usedLeaveDays + $daysRequested) > $limitPerYear) {
            return back()->withErrors([
                'start_date' => "Cuti melebihi batas $limitPerYear hari kerja per tahun. Sudah digunakan: $usedLeaveDays hari.",
            ])->withInput();
        }

        Leave::create([
            'user_id' => $user->id,
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
            'reason' => $request->reason,
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Cuti berhasil diajukan!');
    }

    public function approve($id)
    {
        $leave = Leave::with('user')->findOrFail($id);
        $this->authorizeAdminAction($leave);

        $leave->update(['status' => 'approved']);

        // Buat data kehadiran otomatis selama cuti
        $start = \Carbon\Carbon::parse($leave->start_date);
        $end = \Carbon\Carbon::parse($leave->end_date);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if ($date->isWeekday()) {
                \App\Models\Attendance::updateOrCreate(
                    ['user_id' => $leave->user_id, 'date' => $date->toDateString()],
                    ['status' => 'cuti']
                );
            }
        }

        return redirect()->route('admin.leaves.index')->with('success', 'Cuti disetujui dan rekap kehadiran diperbarui.');
    }

    public function reject($id)
    {
        $leave = Leave::with('user')->findOrFail($id);
        $this->authorizeAdminAction($leave);
        $leave->update(['status' => 'rejected']);

        return redirect()->route('admin.leaves.index')->with('success', 'Cuti ditolak.');
    }

    private function authorizeAdminAction(Leave $leave)
    {
        $user = Auth::user();

        if (
            $user->role !== 'admin' ||
            !$leave->user ||
            $user->company_id !== $leave->user->company_id
        ) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeRole($role)
    {
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
    }
}