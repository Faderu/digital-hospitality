@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Beri Ulasan Layanan') }}
    </h2>
@endsection

@section('content')
<div class="max-w-xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
    <div class="p-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800">Bagaimana pengalaman Anda?</h2>
        <p class="text-gray-500 mt-2">Masukan Anda sangat berharga untuk meningkatkan layanan kami.</p>

        @if(isset($appointment))
            <div class="bg-gray-50 rounded-lg p-4 mt-6 text-left border border-gray-100">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Detail Kunjungan</p>
                <p class="font-bold text-gray-800">{{ $appointment->doctor->name }} - {{ $appointment->doctor->poli->name }}</p>
                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->date)->format('d F Y') }}</p>
            </div>
        @endif

        <form action="{{ route('feedback.store') }}" method="POST" class="mt-8 text-left">
            @csrf
            @if(isset($appointment))
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
            @endif

            <div class="mb-6 text-center">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating Layanan</label>
                <div class="flex justify-center space-x-2 flex-row-reverse group">
                    <input type="radio" name="rating" id="star5" value="5" class="hidden peer/5" required>
                    <label for="star5" class="cursor-pointer text-gray-300 peer-checked/5:text-yellow-400 hover:text-yellow-400 peer-hover/5:text-yellow-400 transition">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </label>
                    
                    <input type="radio" name="rating" id="star4" value="4" class="hidden peer/4">
                    <label for="star4" class="cursor-pointer text-gray-300 peer-checked/4:text-yellow-400 hover:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400 transition">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </label>

                    <input type="radio" name="rating" id="star3" value="3" class="hidden peer/3">
                    <label for="star3" class="cursor-pointer text-gray-300 peer-checked/3:text-yellow-400 hover:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400 transition">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </label>

                    <input type="radio" name="rating" id="star2" value="2" class="hidden peer/2">
                    <label for="star2" class="cursor-pointer text-gray-300 peer-checked/2:text-yellow-400 hover:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400 transition">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </label>

                    <input type="radio" name="rating" id="star1" value="1" class="hidden peer/1">
                    <label for="star1" class="cursor-pointer text-gray-300 peer-checked/1:text-yellow-400 hover:text-yellow-400 peer-hover/1:text-yellow-400 peer-checked/2:text-yellow-400 peer-hover/2:text-yellow-400 peer-checked/3:text-yellow-400 peer-hover/3:text-yellow-400 peer-checked/4:text-yellow-400 peer-hover/4:text-yellow-400 peer-checked/5:text-yellow-400 peer-hover/5:text-yellow-400 transition">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Apa yang bisa kami tingkatkan?</label>
                <textarea name="comment" id="comment" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Tulis pengalaman Anda di sini..."></textarea>
            </div>

            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 text-sm">Batal</a>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-lg font-bold shadow-md transition transform hover:scale-105">
                    Kirim Ulasan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection