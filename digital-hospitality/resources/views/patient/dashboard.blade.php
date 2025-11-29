@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard Pasien') }}
    </h2>
@endsection

@section('content')
<div class="space-y-6">

    <div class="bg-gradient-to-r from-teal-500 to-teal-700 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold">Halo, {{ Auth::user()->name }}!</h1>
            <p class="mt-2 text-teal-100">Jaga kesehatan Anda. Kami siap melayani kebutuhan medis Anda.</p>
            
            <div class="mt-6">
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center bg-white text-teal-700 px-5 py-3 rounded-lg font-bold hover:bg-teal-50 transition shadow-md">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Janji Temu Baru
                </a>
            </div>
        </div>
        <div class="absolute right-0 bottom-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12"></div>
    </div>

    @php
        $lastAppointment = auth()->user()->appointmentsAsPatient()->latest()->first();
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden border-t-4 {{ $lastAppointment ? ($lastAppointment->status == 'approved' ? 'border-blue-500' : ($lastAppointment->status == 'completed' ? 'border-green-500' : 'border-yellow-500')) : 'border-gray-300' }}">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Status Janji Temu Terakhir</h3>
                    @if($lastAppointment)
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                            {{ $lastAppointment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $lastAppointment->status == 'approved' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $lastAppointment->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $lastAppointment->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($lastAppointment->status) }}
                        </span>
                    @endif
                </div>

                @if($lastAppointment)
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ \Carbon\Carbon::parse($lastAppointment->date)->format('l, d F Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <svg class="w-5 h-5 mr-3 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ $lastAppointment->doctor->name }} ({{ $lastAppointment->doctor->poli->name ?? 'Poli' }})</span>
                        </div>

                        @if($lastAppointment->status == 'completed' && !$lastAppointment->feedback)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="{{ route('feedback.create', ['appointment' => $lastAppointment->id]) }}" class="block text-center w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition">
                                    Berikan Penilaian & Feedback
                                </a>
                            </div>
                        @elseif($lastAppointment->status == 'approved')
                            <div class="mt-4 p-3 bg-blue-50 text-blue-700 text-sm rounded border border-blue-100">
                                Silakan datang 15 menit sebelum jadwal dokter.
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-6 text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>Belum ada riwayat janji temu.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Menu Akses</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('appointments.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-teal-50 rounded-lg border border-gray-100 transition group">
                    <div class="p-3 bg-white rounded-full shadow-sm group-hover:bg-teal-200 transition">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-600 group-hover:text-teal-700">Riwayat Janji</span>
                </a>
                <a href="{{ route('medical-records.index') }}" class="flex flex-col items-center justify-center p-4 bg-gray-50 hover:bg-teal-50 rounded-lg border border-gray-100 transition group">
                    <div class="p-3 bg-white rounded-full shadow-sm group-hover:bg-teal-200 transition">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="mt-2 text-sm font-medium text-gray-600 group-hover:text-teal-700">Rekam Medis</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection