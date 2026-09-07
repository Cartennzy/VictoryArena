@extends('layouts.app')

@section('title','Tambah Jadwal')
@section('page_title','Tambah Jadwal')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('schedules.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Lapangan *</label>
            <select name="field" class="form-control" required>
                <option value="Lapangan 1">Lapangan 1</option>
                <option value="Lapangan 2">Lapangan 2</option>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Tanggal *</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col">
                <label>Jam Mulai *</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>
            <div class="col">
                <label>Jam Selesai *</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection