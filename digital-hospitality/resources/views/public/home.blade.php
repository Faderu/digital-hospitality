@extends('layouts.guest')

@section('content')
<div class="text-center">
    <div class="mb-8">
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Selamat Datang</h2>
        <p class="text-teal-600 font-medium">Portal Layanan RS Digital</p>
        <p class="text-gray-500 text-sm mt-2">Akses informasi kesehatan dan jadwal dokter dengan mudah.</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-8">
        <a href="{{ route('public.polis') }}" class="group flex flex-col items-center justify-center p-6 bg-teal-50 border border-teal-100 rounded-xl hover:bg-teal-600 hover:text-white transition duration-300 shadow-sm hover:shadow-lg">
            <div class="p-3 bg-white text-teal-600 rounded-full mb-3 group-hover:bg-teal-500 group-hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span class="font-bold text-sm">Info Poliklinik</span>
        </a>

        <a href="{{ route('public.doctors') }}" class="group flex flex-col items-center justify-center p-6 bg-blue-50 border border-blue-100 rounded-xl hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm hover:shadow-lg">
            <div class="p-3 bg-white text-blue-600 rounded-full mb-3 group-hover:bg-blue-500 group-hover:text-white transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="font-bold text-sm">Jadwal Dokter</span>
        </a>
    </div>

    <div class="space-y-3 pt-6 border-t border-gray-100">
        <a href="{{ route('login') }}" class="block w-full py-3 bg-gray-900 text-white font-bold rounded-lg shadow hover:bg-gray-800 transition transform hover:-translate-y-0.5">
            Masuk (Login)
        </a>
        <a href="{{ route('register') }}" class="block w-full py-3 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-lg hover:border-teal-500 hover:text-teal-600 transition">
            Daftar Pasien Baru
        </a>
    </div>

    <p class="mt-6 text-xs text-gray-400">
        Butuh bantuan darurat? Hubungi <span class="text-red-500 font-bold">IGD 119</span>
    </p>
</div>
@endsection