@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ulasan & Feedback Pasien') }}
    </h2>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-teal-700">Daftar Masukan Pasien</h3>
            <div class="text-sm text-gray-500">
                Total Ulasan: <span class="font-bold text-gray-800">{{ $feedbacks->count() }}</span>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Ref. Kunjungan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($feedbacks as $feedback)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $feedback->created_at->format('d M Y') }}
                            <span class="block text-xs text-gray-400">{{ $feedback->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $feedback->patient->name }}</div>
                            <div class="text-xs text-gray-400">{{ $feedback->patient->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-yellow-400 mr-1 text-lg">★</span>
                                <span class="font-bold text-gray-800">{{ $feedback->rating }}/5</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600 italic">"{{ Str::limit($feedback->comment, 60) ?? 'Tidak ada komentar tertulis' }}"</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                            @if($feedback->appointment)
                                <span class="block font-medium text-gray-700">Dr. {{ $feedback->appointment->doctor->name }}</span>
                                <span class="block">Poli {{ $feedback->appointment->doctor->poli->name ?? '-' }}</span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            Belum ada ulasan yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection