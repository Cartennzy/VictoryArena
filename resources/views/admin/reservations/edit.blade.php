<x-layout.admin-app title="Update Status Booking">

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">

        <h2 class="text-xl font-semibold text-slate-800 mb-8">
            Update Status Booking
        </h2>

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- CUSTOMER --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Customer
                </label>
                <input type="text"
                       value="{{ $reservation->user->name }}"
                       disabled
                       class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-700">
            </div>

            {{-- LAPANGAN --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Lapangan
                </label>
                <input type="text"
                       value="{{ $reservation->field }}"
                       disabled
                       class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-700">
            </div>

            {{-- METODE PEMBAYARAN --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Metode Pembayaran
                </label>
                <input type="text"
                       value="{{ strtoupper($reservation->payment_method ?? '-') }}"
                       disabled
                       class="w-full px-4 py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-700">
            </div>

            {{-- BUKTI PEMBAYARAN --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Bukti Pembayaran
                </label>

                @if ($reservation->payment_proof)
                    <a href="{{ asset('storage/'.$reservation->payment_proof) }}"
                       target="_blank"
                       class="inline-block px-4 py-2 bg-indigo-100 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-200 transition">
                        Lihat Bukti Pembayaran
                    </a>
                @else
                    <p class="text-sm text-slate-500">
                        Customer belum mengupload bukti pembayaran
                    </p>
                @endif
            </div>

            {{-- STATUS BOOKING --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Status Booking
                </label>

                <select name="status"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="pending"  {{ $reservation->status=='pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="approved" {{ $reservation->status=='approved' ? 'selected' : '' }}>
                        Approved
                    </option>
                    <option value="rejected" {{ $reservation->status=='rejected' ? 'selected' : '' }}>
                        Rejected
                    </option>
                </select>
            </div>

            {{-- STATUS PEMBAYARAN --}}
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">
                    Status Pembayaran
                </label>

                <select name="payment_status"
                        required
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="belum_bayar" {{ $reservation->payment_status=='belum_bayar' ? 'selected' : '' }}>
                        Belum Bayar
                    </option>
                    <option value="lunas" {{ $reservation->payment_status=='lunas' ? 'selected' : '' }}>
                        Lunas
                    </option>
                </select>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('reservations.index') }}"
                   class="px-5 py-3 bg-slate-200 text-slate-700 rounded-xl text-sm font-medium hover:bg-slate-300 transition">
                    Kembali
                </a>

                <button type="submit"
                        class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

</x-layout.admin-app>