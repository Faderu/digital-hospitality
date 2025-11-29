@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Jadwal') }}
    </h2>
@endsection

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="bg-teal-600 p-6 text-center">
            <h3 class="text-white text-2xl font-bold">{{ $schedule->day }}</h3>
            <p class="text-teal-100 text-sm mt-1">Jadwal Praktik Mingguan</p>
        </div>

        <div class="p-8">
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-6 h-6 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-lg">Jam Mulai</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</span>
                </div>

                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-6 h-6 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span class="text-lg">Durasi Sesi</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">{{ $schedule->duration_minutes }} Menit</span>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-6 h-6 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="text-lg">Estimasi Selesai</span>
                    </div>
                    <span class="text-xl font-bold text-gray-400">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->addMinutes($schedule->duration_minutes)->format('H:i') }} WIB
                    </span>
                </div>
            </div>

            <div class="mt-8 flex space-x-3">
                <a href="{{ route('schedules.index') }}" class="flex-1 bg-gray-100 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-200 transition font-medium">
                    Kembali
                </a>
                <a href="{{ route('schedules.edit', $schedule) }}" class="flex-1 bg-teal-600 text-white text-center px-4 py-2 rounded-lg hover:bg-teal-700 shadow-md transition font-medium">
                    Edit Jadwal
                </a>
            </div>
        </div>
    </div>
</div>
@endsection