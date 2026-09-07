@extends('layouts.app')

@section('title','Jadwal')
@section('page_title','Jadwal Lapangan')

@section('content')
<div class="card card-modern p-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">List Jadwal</h5>
        <a href="{{ route('schedules.create') }}" class="btn btn-primary">
            + Tambah Jadwal
        </a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
                <th>Customer</th>
                <th width="140px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $s)
            <tr>
                <td>{{ $s->field }}</td>
                <td>{{ $s->date }}</td>
                <td>{{ $s->start_time }} - {{ $s->end_time }}</td>
                <td>
                    @if($s->status=='active')
                        Aktif
                    @elseif($s->status=='finished')
                        Selesai
                    @else
                        Batal
                    @endif
                </td>
                <td>{{ $s->reservation?->customer?->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('schedules.edit',$s->id) }}"
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('schedules.destroy',$s->id) }}"
                          method="POST"
                          class="d-inline swal-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $schedules->links() }}
</div>
@endsection