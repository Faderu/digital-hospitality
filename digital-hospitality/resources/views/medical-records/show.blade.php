@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Rekam Medis') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="bg-white shadow-xl rounded-xl overflow-hidden mb-6 border-t-4 border-teal-600">
        <div class="bg-teal-50 p-6 border-b border-teal-100 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Medis Pasien</h1>
                <p class="text-teal-600">ID Rekam: #RM-{{ str_pad($medicalRecord->id, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase tracking-wide">Tanggal Periksa</p>
                <p class="text-lg font-bold text-gray-800">{{ \Carbon\Carbon::parse($medicalRecord->date)->format('d F Y') }}</p>
            </div>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Data Pasien</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-lg font-bold text-gray-900">{{ $medicalRecord->patient->name }}</p>
                        <p class="text-sm text-gray-600">{{ $medicalRecord->patient->email }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3">Dokter Pemeriksa</h3>
                    <div class="bg-gray-50 p-4 rounded-lg flex items-center">
                        <div class="h-10 w-10 rounded-full bg-teal-200 flex items-center justify-center text-teal-700 font-bold mr-3">
                            Dr
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">{{ $medicalRecord->doctor->name }}</p>
                            <p class="text-sm text-gray-600">{{ $medicalRecord->doctor->poli->name ?? 'Dokter Umum' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-8 border-gray-100">

            <div class="space-y-6">
                <div>
                    <h3 class="text-teal-700 font-bold text-lg mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Diagnosis
                    </h3>
                    <p class="text-gray-800 bg-teal-50 p-4 rounded-lg border border-teal-100 leading-relaxed">
                        {{ $medicalRecord->diagnosis }}
                    </p>
                </div>

                <div>
                    <h3 class="text-teal-700 font-bold text-lg mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Tindakan / Treatment
                    </h3>
                    <p class="text-gray-800 bg-gray-50 p-4 rounded-lg border border-gray-200 leading-relaxed">
                        {{ $medicalRecord->treatment }}
                    </p>
                </div>

                @if($medicalRecord->notes)
                <div>
                    <h3 class="text-gray-600 font-bold text-md mb-2">Catatan Tambahan</h3>
                    <p class="text-gray-600 italic">"{{ $medicalRecord->notes }}"</p>
                </div>
                @endif
            </div>

            <hr class="my-8 border-gray-100">

            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Resep Obat</h3>
                @if($medicalRecord->prescriptions->count() > 0)
                    <div class="overflow-hidden border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah (Qty)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($medicalRecord->prescriptions as $pres)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $pres->medicine->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 text-right">{{ $pres->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 italic bg-gray-50 p-3 rounded">Tidak ada resep obat untuk kunjungan ini.</p>
                @endif
            </div>
        </div>

        <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex justify-between items-center">
            <a href="{{ route('medical-records.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                &larr; Kembali ke Arsip
            </a>
            <button onclick="window.print()" class="text-teal-600 hover:text-teal-800 font-bold text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Laporan
            </button>
        </div>
    </div>
</div>
@endsection