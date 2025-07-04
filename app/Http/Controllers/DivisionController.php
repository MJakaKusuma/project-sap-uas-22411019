<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        // Hanya superadmin yang bisa akses halaman ini
        $this->authorizeRole('superadmin');

        $divisions = Division::latest()->get();
        return view('divisions.index', [
            'list' => $divisions,
            'divisions' => $divisions, // untuk dropdown jika admin
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeRole('superadmin');

        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
        ]);

        Division::create([
            'name' => $request->name,
        ]);

        return redirect()->route('superadmin.divisions.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        $this->authorizeRole('superadmin');
        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $this->authorizeRole('superadmin');

        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name,' . $division->id,
        ]);

        $division->update([
            'name' => $request->name,
        ]);

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        $this->authorizeRole('superadmin');
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }

    protected function authorizeRole($role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
    }
}
