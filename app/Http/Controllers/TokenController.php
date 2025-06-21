<?php
namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function index()
    {
        $tokens = Token::with('company')->get();
        return view('tokens.index', compact('tokens'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('tokens.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'expired_at' => 'required|date|after:now',
        ]);

        $token = Token::create([
            'company_id' => $request->company_id,
            'token' => Str::random(60),
            'used' => false,
            'expired_at' => $request->expired_at,
        ]);

        return redirect()->route('tokens.index')->with('success', 'Token created');
    }

    public function show(Token $token)
    {
        return view('tokens.show', compact('token'));
    }

    public function edit(Token $token)
    {
        $companies = Company::all();
        return view('tokens.edit', compact('token', 'companies'));
    }

    public function update(Request $request, Token $token)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'expired_at' => 'required|date|after:now',
            'used' => 'required|boolean',
        ]);
        $token->update($request->all());
        return redirect()->route('tokens.index')->with('success', 'Token updated');
    }

    public function destroy(Token $token)
    {
        $token->delete();
        return redirect()->route('tokens.index')->with('success', 'Token deleted');
    }
}
