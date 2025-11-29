@extends('layouts.guest')

@section('content')
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Registrasi Pasien</h2>
        <p class="text-sm text-gray-500 mt-1">Buat akun untuk mulai membuat janji temu.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">{{ __('Whoops! Ada kesalahan.') }}</div>
            <ul class="mt-1 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out" 
                   type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Sesuai KTP" />
        </div>

        <div class="mt-4">
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
            <input id="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out" 
                   type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out" 
                   type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition duration-150 ease-in-out">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a class="font-medium text-teal-600 hover:text-teal-500 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500" href="{{ route('login') }}">
                    {{ __('Masuk di sini') }}
                </a>
            </p>
        </div>
    </form>
@endsection