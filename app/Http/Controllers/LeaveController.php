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
            // Admin melihat semua cuti dari user di perusahaan yang sama
            $leaves = Leave::with('user')
                ->whereHas('user', fn($q) => $q->where('company_id', $user->company_id))
                ->latest()->get();
        } elseif ($user->role === 'employee') {
            // Employee hanya melihat cutinya sendiri
            $leaves = Leave::with('user')->where('user_id', $user->id)->latest()->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        // Hanya untuk employee
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

        Leave::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('employee.leaves.index')->with('success', 'Cuti berhasil diajukan!');
    }

    public function approve($id)
    {
        $leave = Leave::findOrFail($id);
        $this->authorizeAdminAction($leave);
        $leave->update(['status' => 'approved']);

        // Generate attendance entries selama cuti
        $start = \Carbon\Carbon::parse($leave->start_date);
        $end = \Carbon\Carbon::parse($leave->end_date);
        for ($date = $start; $date->lte($end); $date->addDay()) {
            Attendance::updateOrCreate([
                'user_id' => $leave->user_id,
                'date' => $date->toDateString()
            ], [
                'status' => 'cuti'
            ]);
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

    /**
     * Memastikan hanya admin yang bisa melakukan aksi approve/reject
     */
    private function authorizeAdminAction(Leave $leave)
    {
        $user = Auth::user();

        if (
            $user->role !== 'admin' ||
            !$leave->user || // prevent error jika user tidak dimuat
            $user->company_id !== $leave->user->company_id
        ) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Fungsi umum untuk batasi akses hanya pada role tertentu
     */
    private function authorizeRole($role)
    {
        if (Auth::user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
    }

}
