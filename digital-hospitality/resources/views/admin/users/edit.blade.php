@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit User') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg overflow-hidden">
    <div class="p-8">
        <div class="mb-6 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-medium text-gray-900">Edit Informasi Akun</h3>
            <p class="text-sm text-gray-500">Perbarui data {{ $user->name }}.</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2 md:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Kosongkan jika tidak diubah">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                </div>

                <div class="col-span-2">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role Pengguna</label>
                    <select name="role" id="role" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" onchange="togglePoli(this.value)">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="doctor" {{ $user->role == 'doctor' ? 'selected' : '' }}>Dokter</option>
                        <option value="patient" {{ $user->role == 'patient' ? 'selected' : '' }}>Pasien</option>
                    </select>
                </div>

                <div class="col-span-2 {{ $user->role != 'doctor' ? 'hidden' : '' }}" id="poli_section">
                    <div class="p-4 bg-teal-50 rounded-lg border border-teal-100">
                        <label for="poli_id" class="block text-sm font-bold text-teal-800 mb-2">Pilih Poliklinik (Wajib untuk Dokter)</label>
                        <select name="poli_id" id="poli_id" class="w-full rounded-md border-teal-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">-- Pilih Poli --</option>
                            @foreach($polis as $poli)
                            <option value="{{ $poli->id }}" {{ $user->poli_id == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-gray-100">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-teal-600 text-white font-medium rounded-lg hover:bg-teal-700 shadow-lg transition">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePoli(role) {
        const poliSection = document.getElementById('poli_section');
        if (role === 'doctor') {
            poliSection.classList.remove('hidden');
        } else {
            poliSection.classList.add('hidden');
        }
    }
</script>
@endsection