@extends('layouts.app')

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

  <x-form action="{{ route('employee.leaves.store') }}" method="POST" title="Form Pengajuan Cuti"
    description="Isi detail pengajuan cuti kamu dengan benar.">

    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

    <div class="form-group">
    <label for="start_date">Tanggal Mulai</label>
    <input type="date" class="form-control" id="start_date" name="start_date" required>
    </div>

    <div class="form-group">
    <label for="end_date">Tanggal Selesai</label>
    <input type="date" class="form-control" id="end_date" name="end_date" required>
    </div>

    <div class="form-group">
    <label for="reason">Alasan Cuti</label>
    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
    </div>

  </x-form>
@endsection