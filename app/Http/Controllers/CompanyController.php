<?php
namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Company::create($request->all());
        return redirect()->route('superadmin.companies.index')->with('success', 'Company created');
    }

    public function show(Company $company)
    {
        return view('superadmin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate(['name' => 'required']);
        $company->update($request->all());
        return redirect()->route('superadmin.companies.index')->with('success', 'Company updated');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('superadmin.companies.index')->with('success', 'Company deleted');
    }
}
