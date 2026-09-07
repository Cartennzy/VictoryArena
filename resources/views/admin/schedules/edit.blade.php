@extends('layouts.app')

@section('title','Edit Jadwal')
@section('page_title','Edit Jadwal')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('schedules.update',$schedule->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Lapangan *</label>
            <select name="field" class="form-control" required>
                <option value="Lapangan 1" {{ $schedule->field=='Lapangan 1' ? 'selected' : '' }}>
                    Lapangan 1
                </option>
                <option value="Lapangan 2" {{ $schedule->field=='Lapangan 2' ? 'selected' : '' }}>
                    Lapangan 2
                </option>
            </select>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Tanggal *</label>
                <input type="date" name="date" class="form-control"
                       value="{{ $schedule->date }}" required>
            </div>
            <div class="col">
                <label>Jam Mulai *</label>
                <input type="time" name="start_time" class="form-control"
                       value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
            </div>
            <div class="col">
                <label>Jam Selesai *</label>
                <input type="time" name="end_time" class="form-control"
                       value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $schedule->status=='active' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="finished" {{ $schedule->status=='finished' ? 'selected' : '' }}>
                    Selesai
                </option>
                <option value="cancelled" {{ $schedule->status=='cancelled' ? 'selected' : '' }}>
                    Batal
                </option>
            </select>
        </div>

        <button class="btn btn-warning">Update</button>
    </form>
</div>
@endsection