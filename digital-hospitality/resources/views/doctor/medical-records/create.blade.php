@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Input Rekam Medis Baru') }}
    </h2>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <div class="lg:col-span-1">
        <div class="bg-white shadow-md rounded-lg overflow-hidden border-t-4 border-teal-500">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Pasien</h3>
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-xl uppercase">
                        {{ substr($appointment->patient->name, 0, 2) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-bold text-gray-900">{{ $appointment->patient->name }}</p>
                        <p class="text-sm text-gray-500">{{ $appointment->patient->email }}</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-100 pt-4 mt-4 space-y-3">
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Keluhan Awal</span>
                        <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md mt-1">{{ $appointment->complaint ?? 'Tidak ada keluhan tercatat' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 uppercase tracking-wider">Jadwal</span>
                        <p class="text-sm text-gray-700 mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ \Carbon\Carbon::parse($appointment->date)->format('l, d F Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-8">
                <form action="{{ route('medical-records.store', $appointment) }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="date" value="{{ $appointment->date }}">

                    <div class="space-y-6">
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis Utama</label>
                            <textarea name="diagnosis" id="diagnosis" rows="2" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Contoh: Infeksi Saluran Pernapasan Akut (ISPA)"></textarea>
                        </div>

                        <div>
                            <label for="treatment" class="block text-sm font-medium text-gray-700 mb-1">Tindakan Medis / Advice</label>
                            <textarea name="treatment" id="treatment" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Tindakan yang dilakukan atau saran kepada pasien..."></textarea>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" id="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"></textarea>
                        </div>

                        <div class="bg-teal-50 p-4 rounded-lg border border-teal-100">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-md font-bold text-teal-800">Resep Obat</label>
                                <button type="button" onclick="addPrescriptionField()" class="text-sm bg-teal-600 hover:bg-teal-700 text-white py-1 px-3 rounded shadow transition flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    Tambah Obat
                                </button>
                            </div>
                            
                            <div id="prescriptions" class="space-y-3">
                                <div class="flex gap-3 items-center bg-white p-2 rounded shadow-sm" data-index="0">
                                    <div class="flex-1">
                                        <select name="medicines[0][id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok: {{ $medicine->stock }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-24">
                                        <input type="number" name="medicines[0][quantity]" placeholder="Qty" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('appointments.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan & Selesaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let index = 1;
    function addPrescriptionField() {
        const container = document.getElementById('prescriptions');
        const newField = document.createElement('div');
        newField.className = 'flex gap-3 items-center bg-white p-2 rounded shadow-sm animate-fade-in-down'; // Tambah class styling
        newField.dataset.index = index;
        
        // HTML String harus match dengan styling row pertama
        newField.innerHTML = `
            <div class="flex-1">
                <select name="medicines[${index}][id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok: {{ $medicine->stock }})</option>
                    @endforeach
                </select>
            </div>
            <div class="w-24">
                <input type="number" name="medicines[${index}][quantity]" placeholder="Qty" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        `;
        container.appendChild(newField);
        index++;
    }
</script>
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fadeInDown 0.3s ease-out; }
</style>
@endsection