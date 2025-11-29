@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Tiket Janji Temu') }}
    </h2>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    
    <div class="mb-6 text-center">
        @if($appointment->status == 'pending')
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Menunggu Konfirmasi</p>
                <p>Janji temu ini sedang menunggu persetujuan dari Dokter atau Admin.</p>
            </div>
        @elseif($appointment->status == 'approved')
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Disetujui / Approved</p>
                <p>Silakan datang tepat waktu sesuai jadwal yang tertera.</p>
            </div>
        @elseif($appointment->status == 'completed')
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Selesai</p>
                <p>Pemeriksaan medis telah selesai dilakukan.</p>
            </div>
        @elseif($appointment->status == 'rejected')
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Ditolak</p>
                <p>Alasan: {{ $appointment->rejection_reason }}</p>
            </div>
        @endif
    </div>

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
        <div class="bg-teal-600 p-6 text-white flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Tiket Antrian</h1>
                <p class="text-teal-100 text-sm">ID Booking: #BKG-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ \Carbon\Carbon::parse($appointment->date)->format('d') }}</div>
                <div class="text-sm uppercase tracking-wider">{{ \Carbon\Carbon::parse($appointment->date)->format('M Y') }}</div>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pasien</h3>
                        <p class="text-lg font-bold text-gray-800">{{ $appointment->patient->name }}</p>
                        <p class="text-sm text-gray-500">{{ $appointment->patient->email }}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Keluhan / Gejala</h3>
                        <div class="bg-gray-50 p-3 rounded-lg mt-1 text-gray-700 text-sm italic border border-gray-100">
                            "{{ $appointment->complaint ?? 'Tidak ada keluhan spesifik.' }}"
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Dokter & Poli</h3>
                        <div class="flex items-center mt-1">
                            <div class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold mr-3">
                                Dr
                            </div>
                            <div>
                                <p class="font-bold text-gray-800">{{ $appointment->doctor->name }}</p>
                                <p class="text-sm text-teal-600">{{ $appointment->doctor->poli->name ?? 'Poli Umum' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jadwal Praktik</h3>
                        <p class="text-lg font-bold text-gray-800 flex items-center mt-1">
                            <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $appointment->schedule->day ?? '-' }}
                        </p>
                        <p class="text-sm text-gray-500 ml-7">
                            Pukul {{ $appointment->schedule ? \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') : '-' }} WIB
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('appointments.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                    &larr; Kembali
                </a>
                <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-900 transition flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Tiket
                </button>
            </div>
        </div>
    </div>
</div>
@endsection