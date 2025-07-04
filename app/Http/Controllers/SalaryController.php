<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\User;
use App\Models\DivisionDetail;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
        $salaries = Salary::with('user')->orderByDesc('payment_date')->get();
        return view('salaries.index', compact('salaries'));
    }

    public function create()
    {
        $authUser = auth()->user();

        if ($authUser->role !== 'admin') {
            abort(403);
        }

        $users = User::with(['company', 'divisionDetail.division'])
            ->where('company_id', $authUser->company_id)
            ->whereIn('role', ['manager', 'employee'])
            ->get();

        return view('salaries.create', compact('users'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        if ($authUser->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'allowance' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'payment_date' => 'required|date',
        ]);

        $targetUser = User::where('id', $request->user_id)
            ->where('company_id', $authUser->company_id)
            ->whereIn('role', ['manager', 'employee'])
            ->first();

        if (!$targetUser) {
            abort(403, 'User tidak ditemukan atau bukan dari perusahaan Anda.');
        }

        // 🚫 Cek apakah sudah ada gaji di bulan yang sama
        $paymentDate = \Carbon\Carbon::parse($request->payment_date);
        $alreadyExists = Salary::where('user_id', $targetUser->id)
            ->whereYear('payment_date', $paymentDate->year)
            ->whereMonth('payment_date', $paymentDate->month)
            ->exists();

        if ($alreadyExists) {
            return back()->withErrors([
                'payment_date' => 'Gaji untuk bulan ini sudah tercatat untuk karyawan ini.'
            ])->withInput();
        }
        $targetUser = User::with('divisionDetail')->findOrFail($request->user_id);
        // Ambil gaji pokok dari relasi divisi
        $divisionDetail = $targetUser->divisionDetail;

        if (!$divisionDetail || !$divisionDetail->basic_salary) {
            return back()->withErrors(['basic_salary' => 'Gaji pokok belum diatur untuk divisi ini.']);
        }

        $basicSalary = $divisionDetail->basic_salary;

        // Simpan data gaji
        $salary = new Salary();
        $salary->user_id = $targetUser->id;
        $salary->basic_salary = $basicSalary;
        $salary->allowance = $request->allowance ?? 0;
        $salary->bonus = $request->bonus ?? 0;
        $salary->deduction = $request->deduction ?? 0;
        $salary->payment_date = $request->payment_date;
        $salary->amount = $salary->basic_salary + $salary->allowance + $salary->bonus - $salary->deduction;
        $salary->save();
        $salary->payment_status = 'pending'; // hardcoded, jangan ambil dari form

        return redirect()->route('admin.salaries.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }


    public function show(Salary $salary)
    {
        return view('salaries.show', compact('salary'));
    }

    public function toggleStatus(Salary $salary)
    {
        $salary->payment_status = $salary->payment_status === 'paid' ? 'pending' : 'paid';
        $salary->save();

        return redirect()->back()->with('success', 'Status pembayaran diperbarui.');
    }

    public function edit(Salary $salary)
    {
        $users = User::all();
        return view('salaries.edit', compact('salary', 'users'));
    }

    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'basic_salary' => 'required|numeric',
            'allowance' => 'nullable|numeric',
            'bonus' => 'nullable|numeric',
            'deduction' => 'nullable|numeric',
            'payment_date' => 'required|date',
        ]);

        $salary->fill($request->all());
        $salary->amount = $salary->basic_salary + $salary->allowance + $salary->bonus - $salary->deduction;
        $salary->save();

        return redirect()->route('salaries.index')->with('success', 'Salary updated');
    }

    public function destroy(Salary $salary)
    {
        $salary->delete();

        return redirect()->route('salaries.index')->with('success', 'Salary deleted');
    }

    public function showByUser()
    {
        $user = auth()->user();

        $salary = Salary::where('user_id', $user->id)
            ->latest('payment_date')
            ->first();

        $salaryHistory = Salary::where('user_id', $user->id)
            ->orderByDesc('payment_date')
            ->get();

        return view('salaries.show', compact('user', 'salary', 'salaryHistory'));
    }

}
