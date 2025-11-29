@extends('layouts.guest')

@section('content')
<div class="text-center mb-6">
    <div class="h-20 w-20 rounded-full bg-teal-100 mx-auto flex items-center justify-center text-teal-600 font-bold text-3xl mb-4 shadow-inner">
        {{ substr($doctor->name, 0, 1) }}
    </div>
    <h2 class="text-2xl font-bold text-gray-900">{{ $doctor->name }}</h2>
    <p class="text-teal-600 font-medium">{{ $doctor->poli->name ?? 'Dokter Umum' }}</p>
    <p class="text-xs text-gray-400 mt-1">{{ $doctor->email }}</p>
</div>

<div class="bg-gray-50 rounded-lg p-5 border border-gray-200 text-left">
    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-3 flex items-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        Jadwal Praktik
    </h3>
    
    @if($doctor->schedules->count() > 0)
        <div class="space-y-3">
            @foreach($doctor->schedules as $schedule)
            <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm border border-gray-100">
                <span class="font-bold text-gray-700">{{ $schedule->day }}</span>
                <div class="text-right">
                    <span class="block text-teal-700 font-bold text-sm">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</span>
                    <span class="block text-xs text-gray-400">{{ $schedule->duration_minutes }} Menit/Sesi</span>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic text-center py-2">Dokter belum memiliki jadwal aktif.</p>
    @endif
</div>

<div class="mt-6 pt-4 flex justify-between items-center border-t border-gray-100">
    <a href="{{ route('public.doctors') }}" class="text-sm text-gray-500 hover:text-gray-800 transition">
        &larr; Kembali
    </a>
    <a href="{{ route('login') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-teal-700 transition shadow">
        Buat Janji
    </a>
</div>
@endsection