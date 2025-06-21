<?php
namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Company;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::with('company')->get();
        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('divisions.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        Division::create($request->all());
        return redirect()->route('divisions.index')->with('success', 'Division created');
    }

    public function show(Division $division)
    {
        return view('divisions.show', compact('division'));
    }

    public function edit(Division $division)
    {
        $companies = Company::all();
        return view('divisions.edit', compact('division', 'companies'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required',
            'company_id' => 'required|exists:companies,id',
        ]);
        $division->update($request->all());
        return redirect()->route('divisions.index')->with('success', 'Division updated');
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted');
    }
}
