@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail User') }}
    </h2>
@endsection

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="h-32 bg-teal-600"></div>
        
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="h-24 w-24 rounded-full bg-white p-1 shadow-lg">
                    <div class="h-full w-full rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-3xl uppercase">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                </div>
                
                <div class="flex space-x-3 mb-2">
                    <a href="{{ route('users.edit', $user) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow transition">
                        Edit Profil
                    </a>
                </div>
            </div>

            <div class="text-left mb-6">
                <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <div class="mt-2">
                    @if($user->role == 'admin')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Administrator</span>
                    @elseif($user->role == 'doctor')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Dokter</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Pasien</span>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-100 pt-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terdaftar Sejak</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Terakhir Update</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->diffForHumans() }}</dd>
                    </div>

                    @if($user->role == 'doctor')
                    <div class="col-span-2 bg-teal-50 p-4 rounded-lg border border-teal-100">
                        <dt class="text-sm font-bold text-teal-800">Poliklinik</dt>
                        <dd class="mt-1 text-lg text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            {{ $user->poli ? $user->poli->name : 'Belum ditentukan' }}
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
            
            <div class="mt-8">
                 <a href="{{ route('users.index') }}" class="text-teal-600 hover:text-teal-800 font-medium text-sm flex items-center">
                    &larr; Kembali ke Daftar User
                </a>
            </div>
        </div>
    </div>
</div>
@endsection