@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Rekam Medis') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Pasien: {{ $medicalRecord->patient->name }}</h3>
                <p class="text-sm text-gray-500">Tanggal Periksa: {{ \Carbon\Carbon::parse($medicalRecord->date)->format('d M Y') }}</p>
            </div>
            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-bold uppercase">Mode Edit</span>
        </div>

        <form action="{{ route('medical-records.update', $medicalRecord) }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="date" value="{{ $medicalRecord->date }}">

            <div class="space-y-6">
                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" rows="2" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ $medicalRecord->diagnosis }}</textarea>
                </div>

                <div>
                    <label for="treatment" class="block text-sm font-medium text-gray-700 mb-1">Tindakan / Advice</label>
                    <textarea name="treatment" id="treatment" rows="3" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ $medicalRecord->treatment }}</textarea>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="notes" id="notes" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ $medicalRecord->notes }}</textarea>
                </div>

                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-md font-bold text-gray-800">Resep Obat</label>
                        <button type="button" onclick="addPrescriptionField()" class="text-sm bg-teal-600 hover:bg-teal-700 text-white py-1 px-3 rounded shadow transition">
                            + Tambah Obat
                        </button>
                    </div>

                    <div id="prescriptions" class="space-y-3">
                        @foreach($medicalRecord->prescriptions as $key => $pres)
                        <div class="flex gap-3 items-center bg-white p-2 rounded shadow-sm" data-index="{{ $key }}">
                            <div class="flex-1">
                                <select name="medicines[{{ $key }}][id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" {{ $pres->medicine_id == $medicine->id ? 'selected' : '' }}>
                                        {{ $medicine->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-24">
                                <input type="number" name="medicines[{{ $key }}][quantity]" value="{{ $pres->quantity }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('medical-records.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition">
                    Update Rekam Medis
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let index = {{ count($medicalRecord->prescriptions) + 1 }};
    function addPrescriptionField() {
        const container = document.getElementById('prescriptions');
        const newField = document.createElement('div');
        newField.className = 'flex gap-3 items-center bg-white p-2 rounded shadow-sm';
        newField.dataset.index = index;
        newField.innerHTML = `
            <div class="flex-1">
                <select name="medicines[${index}][id]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                    <option value="">-- Pilih Obat --</option>
                    @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
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
@endsection