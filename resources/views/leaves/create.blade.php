@extends('layouts.app')

@section('title', 'Ajukan Cuti')

@section('content')
  <div class="page-header">
    <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white me-2">
      <i class="mdi mdi-calendar-plus"></i>
    </span> Ajukan Cuti
    </h3>
    <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      Form Cuti <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
    </nav>
  </div>

  {{-- ✅ Pesan error validasi --}}
  @if ($errors->any())
    <div class="alert alert-danger">
    <ul class="mb-0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
    </div>
  @endif

  {{-- ✅ Info Sisa Cuti --}}
  @isset($leaveRemaining)
    <div class="alert alert-info">
    Kamu memiliki <strong>{{ $leaveRemaining }}</strong> hari cuti tersisa tahun ini.
    </div>
  @endisset

  {{-- ✅ Form Pengajuan --}}
  <x-form action="{{ route('employee.leaves.store') }}" method="POST" title="Form Pengajuan Cuti"
    description="Isi detail pengajuan cuti kamu dengan benar.">

    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

    <div class="form-group">
    <label for="start_date">Tanggal Mulai</label>
    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date"
      value="{{ old('start_date') }}" required>
    @error('start_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group">
    <label for="end_date">Tanggal Selesai</label>
    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date"
      value="{{ old('end_date') }}" required>
    @error('end_date')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

    <div class="form-group">
    <label for="reason">Alasan Cuti</label>
    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3"
      required>{{ old('reason') }}</textarea>
    @error('reason')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    </div>

  </x-form>
@endsection