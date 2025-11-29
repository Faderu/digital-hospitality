@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Jadwal Praktik') }}
    </h2>
@endsection

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-8">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900">Perbarui Jadwal</h3>
            <p class="text-sm text-gray-500">Ubah informasi ketersediaan jadwal praktik Anda.</p>
        </div>

        <form action="{{ route('schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="day" class="block text-sm font-medium text-gray-700 mb-1">Hari Praktik</label>
                    <select name="day" id="day" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition">
                        @php
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        @endphp
                        @foreach($days as $day)
                            <option value="{{ $day }}" {{ $schedule->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                        {{-- Menggunakan format H:i untuk input time --}}
                        <input type="time" name="start_time" id="start_time" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700 mb-1">Durasi per Sesi (Menit)</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" name="duration_minutes" id="duration_minutes" min="30" value="{{ $schedule->duration_minutes }}" required class="w-full rounded-md border-gray-300 pr-12 focus:border-teal-500 focus:ring-teal-500">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">menit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('schedules.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition">
                    Update Jadwal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection