@extends('layouts.guest')

@section('content')
<div class="text-center mb-6">
    <h2 class="text-xl font-bold text-gray-900">Layanan Poliklinik</h2>
    <p class="text-sm text-gray-500">Kami memiliki berbagai spesialisasi medis.</p>
</div>

<div class="max-h-[60vh] overflow-y-auto pr-2 space-y-3 custom-scrollbar">
    @foreach($polis as $poli)
    <div class="flex items-center p-4 bg-white border border-gray-200 rounded-lg hover:border-teal-500 hover:shadow-md transition">
        <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-teal-50 flex items-center justify-center">
            @if($poli->icon)
                <img src="{{ asset('storage/' . $poli->icon) }}" alt="{{ $poli->name }}" class="h-8 w-8 object-contain">
            @else
                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            @endif
        </div>
        
        <div class="ml-4 text-left">
            <h3 class="font-bold text-gray-800">{{ $poli->name }}</h3>
            <p class="text-xs text-gray-500 line-clamp-1">{{ $poli->description ?? 'Layanan medis spesialis.' }}</p>
        </div>
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