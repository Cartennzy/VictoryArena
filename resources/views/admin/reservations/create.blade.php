@extends('layouts.app')

@section('title','Tambah Reservasi')
@section('page_title','Tambah Reservasi Baru')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('reservations.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Customer *</label>
            <select name="customer_id" class="form-control" required>
                <option value="">-- Pilih Customer --</option>
                @foreach($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Lapangan *</label>
            <select name="field" class="form-control" required>
                @foreach($fields as $f)
                    <option value="{{ $f }}">{{ $f }}</option>
                @endforeach
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

        <div class="mb-3">
            <label>Status Reservasi</label>
            <select name="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="confirmed">Dikonfirmasi</option>
                <option value="cancelled">Batal</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status Pembayaran</label>
            <select name="payment_status" class="form-control">
                <option value="unpaid">Belum Bayar</option>
                <option value="paid">Sudah Bayar</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection