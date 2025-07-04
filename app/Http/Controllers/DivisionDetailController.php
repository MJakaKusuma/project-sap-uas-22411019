<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\DivisionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisionDetailController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $details = DivisionDetail::with('division')
            ->where('company_id', $companyId)
            ->get();

        $divisions = Division::all();

        return view('division_details.index', compact('details', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'basic_salary' => 'required|numeric|min:0',
        ]);

        DivisionDetail::create([
            'division_id' => $request->division_id,
            'company_id' => Auth::user()->company_id,
            'basic_salary' => $request->basic_salary,
        ]);

        return redirect()->route('admin.division-details.index')->with('success', 'Detail divisi berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'basic_salary' => 'required|numeric|min:0',
        ]);

        $detail = DivisionDetail::findOrFail($id);

        // Hanya boleh edit jika milik company user
        if ($detail->company_id !== auth()->user()->company_id) {
            abort(403);
        }

        $detail->update([
            'basic_salary' => $request->basic_salary,
        ]);

        return redirect()->route('admin.division-details.index')->with('success', 'Gaji pokok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $detail = DivisionDetail::findOrFail($id);

        // Optional: hanya izinkan hapus jika milik perusahaan sendiri
        if ($detail->company_id != Auth::user()->company_id) {
            abort(403);
        }

        $detail->delete();

        return redirect()->route('admin.division-details.index')->with('success', 'Detail divisi berhasil dihapus.');
    }
}
