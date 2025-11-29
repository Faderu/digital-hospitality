@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Tambah Obat Baru') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-8">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900">Informasi Obat</h3>
            <p class="text-sm text-gray-500">Masukkan detail lengkap obat untuk inventaris rumah sakit.</p>
        </div>

        <form action="{{ route('medicines.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Obat</label>
                    <input type="text" name="name" id="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition" placeholder="Contoh: Paracetamol 500mg">
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Obat</label>
                    <select name="type" id="type" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="biasa">Biasa (OTC)</option>
                        <option value="keras">Keras (Resep Dokter)</option>
                    </select>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Stok Awal</label>
                    <input type="number" name="stock" id="stock" min="0" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="0">
                </div>

                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi & Indikasi</label>
                    <textarea name="description" id="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Jelaskan kegunaan obat ini..."></textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Obat</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="image" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">
                            
                            <img id="preview-img" src="#" alt="Preview Obat" class="hidden w-full h-full object-contain p-2 absolute inset-0 z-10 bg-gray-50">

                            <div id="placeholder-box" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-500"><span class="font-semibold">Klik untuk upload foto</span></p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (Maks. 2MB)</p>
                            </div>

                            <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('medicines.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition">
                    Simpan Data Obat
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        const imageField = document.getElementById('preview-img');
        const placeholder = document.getElementById('placeholder-box');

        reader.onload = function(){
            if(reader.readyState == 2){
                imageField.src = reader.result;
                imageField.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }

        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection