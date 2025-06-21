@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-key-variant"></i>
    </span> Daftar Token
    </h3>
    <a href="{{ route('tokens.create') }}" class="btn btn-gradient-primary mb-3">
    <i class="mdi mdi-plus"></i> Buat Token Baru
    </a>
  </div>

  <x-table title="List Token" description="Daftar token yang tersedia">
    <thead>
    <tr>
      <th>Token</th>
      <th>Perusahaan</th>
      <th>Kadaluarsa</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tokens as $token)
    <tr>
      <td>{{ $token->token }}</td>
      <td>{{ $token->company->name ?? '-' }}</td>
      <td>{{ \Carbon\Carbon::parse($token->expired_at)->format('d-m-Y H:i') }}</td>
      <td>
      @if ($token->used)
      <span class="badge bg-danger">Sudah Digunakan</span>
    @else
      <span class="badge bg-success">Belum Digunakan</span>
    @endif
      </td>
      <td>
      <a href="{{ route('tokens.edit', $token->id) }}" class="btn btn-sm btn-warning">Edit</a>
      <form action="{{ route('tokens.destroy', $token->id) }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus token ini?')">Hapus</button>
      </form>
      </td>
    </tr>
    @endforeach
    </tbody>
  </x-table>
@endsection