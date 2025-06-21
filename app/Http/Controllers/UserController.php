<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();

        if ($authUser->role === 'superadmin') {
            $users = User::with(['company', 'division'])
                ->where('role', 'admin')
                ->get();
        } elseif ($authUser->role === 'admin') {
            $users = User::with(['company', 'division'])
                ->where('company_id', $authUser->company_id)
                ->whereIn('role', ['manager', 'employee'])
                ->get();
        } else {
            abort(403);
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $companies = Company::all();
        $divisions = Division::all();
        return view('users.create', compact('companies', 'divisions'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin,manager,employee',
            'division_id' => 'nullable|exists:divisions,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($authUser->role === 'superadmin') {
            // Jika role admin, wajib pilih company_id
            if ($request->role === 'admin') {
                $request->validate([
                    'company_id' => 'required|exists:companies,id',
                ]);
                $companyId = $request->company_id;
            } else {
                // Untuk role selain admin, company_id juga bisa pilih bebas
                $request->validate([
                    'company_id' => 'required|exists:companies,id',
                ]);
                $companyId = $request->company_id;
            }
        } elseif ($authUser->role === 'admin') {
            // Admin hanya bisa buat manager/employee dengan company_id sesuai admin login
            if (!in_array($request->role, ['manager', 'employee'])) {
                abort(403, 'Admin hanya boleh membuat user dengan role manager atau employee.');
            }
            $companyId = $authUser->company_id;
        } else {
            abort(403);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_id' => $companyId,
            'division_id' => $request->division_id,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $redirectRoute = $authUser->role === 'superadmin'
            ? 'superadmin.users.index'
            : 'admin.users.index';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil dibuat');
    }

    public function show(User $user)
    {
        $user->load(['company', 'division']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $companies = Company::all();
        $divisions = Division::all();
        return view('users.edit', compact('user', 'companies', 'divisions'));
    }

    public function update(Request $request, User $user)
    {

        $authUser = auth()->user();
        if ($authUser->role === 'superadmin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$user->id}",
                'password' => 'nullable|string|min:6|confirmed',
                'role' => 'required|in:superadmin,admin,manager,employee',
                'company_id' => 'nullable|exists:companies,id',
                'division_id' => 'nullable|exists:divisions,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $data = $request->only([
                'name',
                'email',
                'role',
                'company_id',
                'division_id',
                'phone',
                'address'
            ]);

        } elseif ($authUser->role === 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$user->id}",
                'password' => 'nullable|string|min:6|confirmed',
                'company_id' => 'nullable|exists:companies,id',
                'division_id' => 'nullable|exists:divisions,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $data = $request->only([
                'name',
                'email',
                'role',
                'company_id',
                'division_id',
                'phone',
                'address'
            ]);
        } else {
            abort(403);
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $redirectRoute = $authUser->role === 'superadmin'
            ? 'superadmin.users.index'
            : 'admin.users.index';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil diubah');
    }

    public function destroy(User $user)
    {
        $user->delete();

        $redirectRoute = auth()->user()->role === 'superadmin'
            ? 'superadmin.users.index'
            : 'admin.users.index';

        return redirect()->route($redirectRoute)->with('success', 'User berhasil dihapus');
    }
}
