@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Dokter') }}
    </h2>
@endsection

@section('content')
<div class="space-y-8">

    <div class="rounded-2xl p-8 text-white shadow-xl relative overflow-hidden" 
        style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size: cover; background-position: center;">
        
        <div class="absolute inset-0 bg-teal-800 opacity-75 z-0"></div>

        <div class="relative z-10">
            <h1 class="text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 text-teal-100">Selamat bertugas. Berikut adalah ringkasan aktivitas medis Anda hari ini.</p>
            
            <div class="mt-6 flex space-x-3">
                <a href="{{ route('schedules.index') }}" class="bg-white text-teal-700 px-4 py-2 rounded-lg font-bold hover:bg-teal-50 transition shadow-sm flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Atur Jadwal
                </a>
                <a href="{{ route('appointments.index') }}" class="bg-teal-500 text-white px-4 py-2 rounded-lg font-bold hover:bg-teal-400 transition shadow-sm border border-teal-400 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Validasi Janji Temu
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-400 hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->appointmentsAsDoctor()->where('status', 'pending')->count() }}
                    </p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
            </div>
            <a href="{{ route('appointments.index') }}" class="text-sm text-yellow-600 font-medium mt-4 inline-block hover:underline">Lihat Permintaan &rarr;</a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-teal-500 hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Pasien Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->appointmentsAsDoctor()->where('status', 'approved')->whereDate('date', now())->count() }}
                    </p>
                </div>
                <div class="p-3 bg-teal-50 rounded-full text-teal-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <p class="text-sm text-gray-400 mt-4">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 hover:shadow-lg transition">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Pasien Diperiksa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">
                        {{ auth()->user()->medicalRecordsAsDoctor()->count() }}
                    </p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <a href="{{ route('medical-records.index') }}" class="text-sm text-blue-600 font-medium mt-4 inline-block hover:underline">Lihat Riwayat &rarr;</a>
        </div>
    </div>

    <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-800">Pasien Terakhir Diperiksa</h3>
            <a href="{{ route('medical-records.index') }}" class="text-sm text-teal-600 hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    {{-- Logic Blade untuk mengambil 5 data terakhir --}}
                    @php
                        $recentRecords = auth()->user()->medicalRecordsAsDoctor()->with('patient')->latest()->take(5)->get();
                    @endphp

                    @forelse($recentRecords as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xs uppercase mr-3">
                                    {{ substr($record->patient->name, 0, 2) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $record->patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ Str::limit($record->diagnosis, 30) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('medical-records.show', $record) }}" class="text-teal-600 hover:text-teal-900 font-semibold">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 italic">
                            Belum ada pasien yang diperiksa.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection