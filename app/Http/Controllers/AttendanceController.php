<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $companyId = auth()->user()->company_id;
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;
        $today = Carbon::today();

        $users = User::where('company_id', $companyId)
            ->whereIn('role', ['employee', 'manager'])
            ->with([
                'attendances' => function ($query) use ($month, $year) {
                    $query->whereMonth('date', $month)
                        ->whereYear('date', $year);
                }
            ])->get();

        // Tambahkan data 'alpa' otomatis jika hari ini weekday dan user belum absen
        if ($today->isWeekday()) {
            foreach ($users as $user) {
                $hasAttendanceToday = $user->attendances->contains(function ($attendance) use ($today) {
                    return $attendance->date === $today->toDateString();
                });

                if (!$hasAttendanceToday) {
                    Attendance::updateOrCreate(
                        ['user_id' => $user->id, 'date' => $today->toDateString()],
                        ['status' => 'alpa']
                    );
                }
            }
        }

        return view('attendances.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('company_id', auth()->user()->company_id)
            ->whereIn('role', ['employee', 'manager'])
            ->get();

        return view('admin.attendances.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,sakit,izin,cuti,alpa',
        ]);

        Attendance::updateOrCreate(
            ['user_id' => $request->user_id, 'date' => $request->date],
            ['status' => $request->status]
        );

        return redirect()->route('admin.attendances.index')->with('success', 'Absensi berhasil disimpan.');
    }

    public function markHadir()
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        $existing = $user->attendances()->where('date', $today)->first();

        if ($existing) {
            if ($existing->status === 'hadir') {
                return back()->with('info', 'Anda sudah absen hadir hari ini.');
            } else {
                return back()->with('warning', 'Hari ini Anda berstatus ' . strtoupper($existing->status) . ', tidak bisa absen hadir.');
            }
        }

        $user->attendances()->create([
            'date' => $today,
            'status' => 'hadir',
        ]);

        return back()->with('success', 'Absensi hadir berhasil disimpan!');
    }
}
