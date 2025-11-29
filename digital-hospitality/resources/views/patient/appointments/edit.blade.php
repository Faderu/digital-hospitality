@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ubah Janji Temu') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl overflow-hidden">
    <div class="p-8">
        <div class="mb-6 border-b border-gray-100 pb-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Edit Data Booking</h2>
                <p class="text-sm text-gray-500">Ubah detail jadwal kunjungan Anda.</p>
            </div>
            <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold">Mode Edit</span>
        </div>

        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="mb-4">
                    <label for="poli_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Poli</label>
                    <select name="poli_id" id="poli_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" onchange="loadDoctors(this.value)">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                        <option value="{{ $poli->id }}" {{ $appointment->poli_id == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Dokter</label>
                    <select name="doctor_id" id="doctor_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" onchange="loadSchedules(this.value)">
                        {{-- Opsi Dokter akan di-load via JS, tapi kita tampilkan selected awal --}}
                        <option value="{{ $appointment->doctor_id }}" selected>{{ $appointment->doctor->name }}</option>
                    </select>
                </div>
            </div>

            <div class="mb-4 bg-teal-50 p-4 rounded-lg border border-teal-100">
                <label for="schedule_id" class="block text-sm font-bold text-teal-800 mb-1">Pilih Jadwal</label>
                <select name="schedule_id" id="schedule_id" required class="w-full rounded-md border-teal-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                     {{-- Opsi Jadwal akan di-load via JS, tapi kita tampilkan selected awal --}}
                     <option value="{{ $appointment->schedule_id }}" selected>
                        {{ $appointment->schedule->day }} - {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') }}
                     </option>
                </select>
                <p class="text-xs text-gray-500 mt-2">Jika Anda mengubah Poli/Dokter, silakan pilih ulang jadwal.</p>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Booking</label>
                <input type="date" name="date" id="date" value="{{ $appointment->date }}" min="{{ now()->format('Y-m-d') }}" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
            </div>
            
            <div class="mb-6">
                <label for="complaint" class="block text-sm font-medium text-gray-700 mb-1">Keluhan Singkat</label>
                <textarea name="complaint" id="complaint" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">{{ $appointment->complaint }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-100 pt-5">
                <a href="{{ route('appointments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-6 py-2 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 shadow transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- Script JS Sama seperti Create, tapi kita perlu handle agar tidak mereset data awal jika tidak diklik --}}
<script>
    function loadDoctors(poliId) {
        if (!poliId) return;
        const doctorSelect = document.getElementById('doctor_id');
        const scheduleSelect = document.getElementById('schedule_id');
        
        doctorSelect.innerHTML = '<option value="">Loading...</option>';
        doctorSelect.disabled = true;

        fetch(`{{ url('/api/polis') }}/${poliId}/doctors`)
            .then(res => res.json())
            .then(data => {
                doctorSelect.innerHTML = '<option value="">-- Pilih Dokter Baru --</option>';
                data.forEach(doctor => doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`);
                doctorSelect.disabled = false;
                
                // Reset Jadwal jika Poli berubah
                scheduleSelect.innerHTML = '<option value="">-- Pilih Dokter Terlebih Dahulu --</option>';
            });
    }

    function loadSchedules(doctorId) {
        if (!doctorId) return;
        const scheduleSelect = document.getElementById('schedule_id');
        scheduleSelect.innerHTML = '<option value="">Loading...</option>';
        scheduleSelect.disabled = true;

        fetch(`{{ url('/api/doctors') }}/${doctorId}/schedules`)
            .then(res => res.json())
            .then(data => {
                scheduleSelect.innerHTML = '<option value="">-- Pilih Jadwal Baru --</option>';
                data.forEach(schedule => {
                    scheduleSelect.innerHTML += `<option value="${schedule.id}">${schedule.day} - ${schedule.start_time.substring(0,5)}</option>`;
                });
                scheduleSelect.disabled = false;
            });
    }
</script>
@endsection