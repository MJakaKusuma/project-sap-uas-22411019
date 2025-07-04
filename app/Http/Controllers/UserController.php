<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Division;
use App\Models\DivisionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        // Include relasi company dan divisionDetail -> division
        $query = User::with(['company', 'divisionDetail.division']);

        if ($authUser->role === 'superadmin') {
            $query->where('role', 'admin');
        } elseif ($authUser->role === 'admin') {
            $query->where('company_id', $authUser->company_id)
                ->whereIn('role', ['manager', 'employee']);
        } else {
            abort(403);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('sort_by')) {
            $query->orderBy($request->sort_by, $request->get('order', 'asc'));
        } else {
            $query->orderBy('name');
        }

        $users = $query->paginate(10)->appends($request->query());
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $companies = Company::all();

        $divisions = auth()->user()->role === 'superadmin'
            ? DivisionDetail::with('division', 'company')->get()
            : DivisionDetail::with('division')
                ->where('company_id', auth()->user()->company_id)
                ->get();

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
            'division_detail_id' => 'nullable|exists:division_details,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($authUser->role === 'superadmin') {
            $request->validate(['company_id' => 'required|exists:companies,id']);
            $companyId = $request->company_id;
        } elseif ($authUser->role === 'admin') {
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
            'division_detail_id' => $request->division_detail_id,
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
        $user->load(['company', 'divisionDetail.division']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $companies = Company::all();

        $divisions = auth()->user()->role === 'superadmin'
            ? DivisionDetail::with('division', 'company')->get()
            : DivisionDetail::with('division')
                ->where('company_id', auth()->user()->company_id)
                ->get();

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
                'company_id' => 'required|exists:companies,id',
                'division_detail_id' => 'nullable|exists:division_details,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $data = $request->only([
                'name',
                'email',
                'role',
                'company_id',
                'division_detail_id',
                'phone',
                'address'
            ]);
        } elseif ($authUser->role === 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => "required|email|unique:users,email,{$user->id}",
                'password' => 'nullable|string|min:6|confirmed',
                'division_detail_id' => 'nullable|exists:division_details,id',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            $data = $request->only(['name', 'email', 'division_detail_id', 'phone', 'address']);
            $data['role'] = $user->role;
            $data['company_id'] = $authUser->company_id;
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
