@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Poli') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:shrink-0 bg-teal-50 p-8 flex items-center justify-center md:w-48 border-r border-teal-100">
                @if($poli->icon)
                    <img class="h-32 w-32 object-contain p-2 bg-white rounded-full shadow-md" src="{{ asset('storage/' . $poli->icon) }}" alt="{{ $poli->name }}">
                @else
                    <div class="h-32 w-32 rounded-full bg-teal-200 flex items-center justify-center text-teal-700 shadow-inner">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                @endif
            </div>

            <div class="p-8 w-full">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $poli->name }}</h1>
                        <p class="text-sm text-teal-600 font-medium mt-1">Departemen Medis</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('polis.edit', $poli) }}" class="p-2 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-100 transition" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Deskripsi Layanan</h3>
                    <p class="text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-lg border border-gray-100">
                        {{ $poli->description ?? 'Tidak ada deskripsi tersedia.' }}
                    </p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-xs text-gray-400">Terakhir diupdate: {{ $poli->updated_at->diffForHumans() }}</span>
                    <a href="{{ route('polis.index') }}" class="text-teal-600 hover:text-teal-800 font-medium text-sm flex items-center">
                        &larr; Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection