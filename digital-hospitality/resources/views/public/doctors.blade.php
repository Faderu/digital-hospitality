@extends('layouts.guest')

@section('content')
<div class="text-center mb-6">
    <h2 class="text-xl font-bold text-gray-900">Jadwal Dokter</h2>
    <p class="text-sm text-gray-500">Cari dokter spesialis dan jadwal praktiknya.</p>
</div>

<div class="max-h-[60vh] overflow-y-auto pr-2 space-y-4 custom-scrollbar">
    @foreach($doctors as $doctor)
    <div class="bg-white border border-gray-200 rounded-lg p-4 hover:border-teal-500 transition shadow-sm relative group">
        <div class="flex items-start">
            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg flex-shrink-0">
                Dr
            </div>
            <div class="ml-3 text-left w-full">
                <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition">{{ $doctor->name }}</h3>
                <span class="inline-block bg-teal-50 text-teal-700 text-xs px-2 py-0.5 rounded-full font-medium mb-2">
                    {{ $doctor->poli->name ?? 'Dokter Umum' }}
                </span>
                
                <div class="space-y-1">
                    @forelse($doctor->schedules as $schedule)
                        <div class="text-xs text-gray-500 flex items-center">
                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="font-medium text-gray-700 w-12">{{ $schedule->day }}</span>
                            <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</span>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic">Jadwal belum tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
        <a href="{{ route('public.doctor.profile', $doctor) }}" class="absolute inset-0 z-10" title="Lihat Profil"></a>
    </div>
    @endforeach
</div>

<div class="mt-6 pt-4 border-t border-gray-100">
    <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-teal-600 transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Beranda
    </a>
</div>
@endsection