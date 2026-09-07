@extends('layouts.app')

@section('title','Tambah Customer')
@section('page_title','Tambah Customer')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama *</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>No. Telepon</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection