@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Obat') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="md:flex">
        <div class="md:shrink-0 md:w-1/3 bg-gray-100 flex items-center justify-center p-6 border-r border-gray-200">
            @if($medicine->image)
                <img class="h-64 w-full object-cover rounded-lg shadow-sm" src="{{ asset('storage/' . $medicine->image) }}" alt="{{ $medicine->name }}">
            @else
                <div class="h-64 w-full flex flex-col items-center justify-center text-gray-400">
                    <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Tidak ada gambar</span>
                </div>
            @endif
        </div>

        <div class="p-8 w-full">
            <div class="flex justify-between items-start">
                <div>
                    <div class="uppercase tracking-wide text-sm text-teal-600 font-bold mb-1">{{ $medicine->type == 'keras' ? 'Obat Keras (Resep)' : 'Obat Bebas (OTC)' }}</div>
                    <h1 class="block mt-1 text-3xl leading-tight font-bold text-gray-900">{{ $medicine->name }}</h1>
                </div>
                @if($medicine->stock > 0)
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        Stok Tersedia
                    </span>
                @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                        Stok Habis
                    </span>
                @endif
            </div>

            <p class="mt-6 text-gray-600 leading-relaxed">
                {{ $medicine->description ?? 'Tidak ada deskripsi tersedia untuk obat ini.' }}
            </p>

            <div class="mt-8 grid grid-cols-2 gap-4 border-t border-gray-100 pt-6">
                <div>
                    <span class="text-gray-500 text-sm">Sisa Stok</span>
                    <p class="text-2xl font-bold text-gray-800">{{ $medicine->stock }} <span class="text-sm font-normal text-gray-500">Unit</span></p>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">Terakhir Diupdate</span>
                    <p class="text-md font-medium text-gray-800">{{ $medicine->updated_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="mt-8 flex space-x-3">
                <a href="{{ route('medicines.index') }}" class="flex-1 bg-gray-100 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                    Kembali
                </a>
                <a href="{{ route('medicines.edit', $medicine) }}" class="flex-1 bg-teal-600 text-white text-center px-4 py-2 rounded-lg hover:bg-teal-700 shadow-md transition">
                    Edit Data
                </a>
            </div>
        </div>
    </div>
</div>
@endsection