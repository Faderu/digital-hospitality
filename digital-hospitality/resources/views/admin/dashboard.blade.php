@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
<div class="space-y-8">
    
    <div class="rounded-2xl p-8 text-white shadow-xl relative overflow-hidden mb-10" 
        style="background-image: url('{{ asset('images/hero-bg.jpg') }}'); background-size: cover; background-position: center;">
        
        <div class="absolute inset-0 bg-teal-900 opacity-75 z-0"></div>

        <div class="relative z-10 max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Selamat Datang, Administrator!</h1>
            <p class="mt-4 text-teal-100 text-lg">Berikut adalah ringkasan aktivitas operasional rumah sakit hari ini.</p>
        </div>
    </div>
        <div class="absolute right-0 top-0 h-full w-1/2 bg-white opacity-5 transform skew-x-12"></div>
        <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-teal-400 opacity-20 rounded-full blur-3xl"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-yellow-400 flex items-center justify-between hover:shadow-lg transition duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Janji Temu Pending</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\Appointment::where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="p-4 bg-yellow-50 rounded-full text-yellow-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-blue-500 flex items-center justify-between hover:shadow-lg transition duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\User::count() }}
                </p>
            </div>
            <div class="p-4 bg-blue-50 rounded-full text-blue-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-teal-500 flex items-center justify-between hover:shadow-lg transition duration-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Dokter Bertugas Hari Ini</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">
                    {{ \App\Models\Schedule::where('day', \Carbon\Carbon::now()->locale('id')->isoFormat('dddd'))->count() }}
                </p>
            </div>
            <div class="p-4 bg-teal-50 rounded-full text-teal-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-200">Akses Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('reports.index') }}" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-100 flex items-start transition duration-200">
                <div class="p-3 bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-indigo-600 transition">Laporan & Analitik</h4>
                    <p class="text-sm text-gray-500 mt-1">Lihat statistik kinerja dokter dan penggunaan obat.</p>
                </div>
            </a>

            <a href="{{ route('feedback.index') }}" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-100 flex items-start transition duration-200">
                <div class="p-3 bg-pink-100 text-pink-600 rounded-lg group-hover:bg-pink-600 group-hover:text-white transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-pink-600 transition">Feedback Pasien</h4>
                    <p class="text-sm text-gray-500 mt-1">Review kepuasan pasien terhadap layanan.</p>
                </div>
            </a>

             <a href="{{ route('users.create') }}" class="group bg-white p-6 rounded-xl shadow-sm hover:shadow-md border border-gray-100 flex items-start transition duration-200">
                <div class="p-3 bg-green-100 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <div class="ml-4">
                    <h4 class="text-lg font-bold text-gray-800 group-hover:text-green-600 transition">Tambah User</h4>
                    <p class="text-sm text-gray-500 mt-1">Registrasi akun dokter atau admin baru.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection