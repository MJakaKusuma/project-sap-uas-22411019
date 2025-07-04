@extends('layouts.app')
@section('title', 'Input Gaji Karyawan')

@section('content')
  <div class="page-header">
    <h3 class="page-title"> Input Gaji Karyawan </h3>
  </div>

  <div class="card">
    <div class="card-body">
    @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.salaries.store') }}" method="POST">
      @csrf

      <div class="form-group">
      <label for="user_id">Karyawan</label>
      <select name="user_id" class="form-control" required>
        <option value="">Pilih Karyawan</option>
        @foreach($users as $user)
      <option value="{{ $user->id }}">
      {{ $user->name }} - {{ $user->division()?->name ?? '-' }}
      </option>
      @endforeach
      </select>
      </div>

      <div class="form-group">
      <label>Tunjangan</label>
      <input type="number" name="allowance" class="form-control">
      </div>

      <div class="form-group">
      <label>Bonus</label>
      <input type="number" name="bonus" class="form-control">
      </div>

      <div class="form-group">
      <label>Potongan</label>
      <input type="number" name="deduction" class="form-control">
      </div>

      <div class="form-group">
      <label>Tanggal Pembayaran</label>
      <input type="date" name="payment_date" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary">Simpan Gaji</button>
    </form>
    </div>
  </div>
@endsection