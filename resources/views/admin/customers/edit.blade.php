@extends('layouts.app')

@section('title','Edit Customer')
@section('page_title','Edit Customer')

@section('content')
<div class="card card-modern p-4">
    <form action="{{ route('customers.update',$customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama *</label>
            <input type="text"
                   name="name"
                   value="{{ old('name',$customer->name) }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>No. Telepon *</label>
            <input type="text"
                   name="phone"
                   value="{{ old('phone',$customer->phone) }}"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email',$customer->email) }}"
                   class="form-control">
        </div>

        <button class="btn btn-warning">
            Update
        </button>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Batal
        </a>
    </form>
</div>
@endsection