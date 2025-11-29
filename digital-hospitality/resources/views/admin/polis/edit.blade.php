@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Poliklinik') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-8">
        <form action="{{ route('polis.update', $poli) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Poli</label>
                    <input type="text" name="name" id="name" value="{{ $poli->name }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Layanan</label>
                    <textarea name="description" id="description" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ $poli->description }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ikon Poli</label>
                    
                    <div class="flex items-center gap-6">
                        <div class="shrink-0 text-center">
                            <span class="block text-xs text-gray-500 mb-1">Preview</span>
                            
                            <div class="relative w-32 h-32 bg-gray-50 rounded-lg border border-gray-200 flex items-center justify-center overflow-hidden">
                                <img id="img-preview" 
                                     src="{{ $poli->icon ? asset('storage/' . $poli->icon) : '' }}" 
                                     alt="Icon Preview" 
                                     class="{{ $poli->icon ? '' : 'hidden' }} w-full h-full object-contain p-2">
                                
                                <div id="no-img-text" class="{{ $poli->icon ? 'hidden' : '' }} text-gray-400 text-xs">
                                    No Icon
                                </div>
                            </div>
                        </div>

                        <div class="flex-1">
                            <label class="block text-sm text-gray-600 mb-1">Ganti Ikon</label>
                            <input type="file" name="icon" id="icon" accept="image/*" onchange="previewEditImage(event)"
                                class="block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-teal-50 file:text-teal-700
                                hover:file:bg-teal-100
                            "/>
                            <p class="mt-1 text-xs text-gray-500">Pilih file baru untuk mengganti ikon saat ini.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 border-t border-gray-100 pt-5">
                <a href="{{ route('polis.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition">
                    Update Poli
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script Preview Edit --}}
<script>
    function previewEditImage(event) {
        const reader = new FileReader();
        const output = document.getElementById('img-preview');
        const placeholder = document.getElementById('no-img-text');

        reader.onload = function(){
            output.src = reader.result;
            output.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        };

        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection