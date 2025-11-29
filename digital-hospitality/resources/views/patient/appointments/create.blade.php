@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Buat Janji Temu') }}
    </h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl overflow-hidden border-t-4 border-teal-600">
    <div class="p-8">
        
        <div class="mb-8 border-b border-gray-100 pb-4">
            <h1 class="text-2xl font-bold text-gray-900">Formulir Pendaftaran Pasien</h1>
            <p class="text-gray-500 mt-1">Isi data berikut untuk menjadwalkan konsultasi dengan dokter.</p>
        </div>

        {{-- Menampilkan Error Global jika ada --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <p class="font-bold">Perhatian!</p>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('appointments.store') }}" method="POST" id="bookingForm">
            @csrf

            <div class="mb-6">
                <label for="poli_id" class="block text-sm font-bold text-gray-700 mb-2">1. Pilih Poliklinik</label>
                <div class="relative">
                    <select name="poli_id" id="poli_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 pl-4 pr-10" onchange="loadDoctors(this.value)">
                        <option value="">-- Silakan Pilih Poli --</option>
                        @foreach($polis as $poli)
                        <option value="{{ $poli->id }}" {{ old('poli_id') == $poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="doctor_id" class="block text-sm font-bold text-gray-700 mb-2">2. Pilih Dokter</label>
                <select name="doctor_id" id="doctor_id" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3 disabled:bg-gray-100 disabled:text-gray-400" onchange="loadSchedules(this.value)" disabled>
                    <option value="">-- Pilih Dokter --</option>
                </select>
            </div>

            <div id="schedule_section" class="mb-6 hidden animate-fade-in">
                <label class="block text-sm font-bold text-gray-700 mb-2">3. Pilih Jadwal Praktik Dokter</label>
                <p class="text-xs text-gray-500 mb-3">Klik pada salah satu kartu jadwal di bawah ini:</p>
                
                <div id="schedule_options" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    </div>
                <input type="hidden" name="schedule_id" id="schedule_id" required>
                @error('schedule_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="final_section" class="hidden animate-fade-in border-t border-gray-100 pt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="date" class="block text-sm font-bold text-gray-700 mb-2">4. Tanggal Kunjungan</label>
                        {{-- Tambahkan class error visual --}}
                        <input type="date" name="date" id="date" min="{{ now()->format('Y-m-d') }}" required 
                               class="block w-full rounded-lg shadow-sm py-3 focus:ring-teal-500 focus:border-teal-500 
                               @error('date') border-red-500 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500 @else border-gray-300 @enderror">
                        
                        {{-- PESAN ERROR SPESIFIK TANGGAL --}}
                        @error('date')
                            <p class="mt-2 text-sm text-red-600 font-medium bg-red-50 p-2 rounded border border-red-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                        
                        <p class="text-xs text-teal-600 mt-2 font-medium" id="date_hint">
                            <span id="target_day_badge" class="hidden bg-teal-100 text-teal-800 px-2 py-1 rounded"></span>
                        </p>
                    </div>

                    <div>
                        <label for="complaint" class="block text-sm font-bold text-gray-700 mb-2">5. Keluhan Singkat</label>
                        <textarea name="complaint" id="complaint" rows="1" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Contoh: Demam, Pusing..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('appointments.index') }}" class="mr-3 px-6 py-3 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-teal-600 text-white font-bold rounded-lg shadow-lg hover:bg-teal-700 transform transition hover:-translate-y-1">
                        Buat Janji Temu
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const poliSelect = document.getElementById('poli_id');
    const doctorSelect = document.getElementById('doctor_id');
    const scheduleSection = document.getElementById('schedule_section');
    const scheduleOptions = document.getElementById('schedule_options');
    const scheduleInput = document.getElementById('schedule_id');
    const finalSection = document.getElementById('final_section');
    const dateInput = document.getElementById('date');
    const dateHint = document.getElementById('date_hint');
    const targetDayBadge = document.getElementById('target_day_badge');

    // Variabel untuk menyimpan hari yang diharapkan (Contoh: "Senin")
    let expectedDay = null;

    function loadDoctors(poliId) {
        // Reset
        doctorSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
        doctorSelect.disabled = true;
        scheduleSection.classList.add('hidden');
        finalSection.classList.add('hidden');

        if (!poliId) return;

        fetch(`{{ url('/api/polis') }}/${poliId}/doctors`)
            .then(res => res.json())
            .then(data => {
                doctorSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
                data.forEach(doctor => {
                    doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
                });
                doctorSelect.disabled = false;
            });
    }

    window.loadDoctors = loadDoctors; // Make accessible globally

    window.loadSchedules = function(doctorId) {
        // Reset
        scheduleOptions.innerHTML = '';
        scheduleSection.classList.add('hidden');
        finalSection.classList.add('hidden');
        expectedDay = null;

        if (!doctorId) return;

        fetch(`{{ url('/api/doctors') }}/${doctorId}/schedules`)
            .then(res => res.json())
            .then(data => {
                scheduleSection.classList.remove('hidden');
                
                if(data.length === 0) {
                    scheduleOptions.innerHTML = '<p class="text-gray-500 col-span-3 text-center">Dokter ini belum memiliki jadwal.</p>';
                    return;
                }

                data.forEach(schedule => {
                    const start = schedule.start_time.substring(0, 5);
                    const card = document.createElement('div');
                    card.className = 'border-2 border-gray-200 rounded-lg p-4 cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition schedule-card';
                    // Simpan nama hari di dataset
                    card.dataset.day = schedule.day; 
                    card.dataset.id = schedule.id;
                    
                    card.innerHTML = `
                        <div class="font-bold text-teal-700 text-lg">${schedule.day}</div>
                        <div class="text-gray-600 mt-1 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            ${start} WIB
                        </div>
                    `;

                    card.addEventListener('click', function() {
                        // Highlight Logic
                        document.querySelectorAll('.schedule-card').forEach(c => {
                            c.classList.remove('border-teal-600', 'bg-teal-100', 'ring-2', 'ring-teal-300');
                            c.classList.add('border-gray-200');
                        });
                        this.classList.remove('border-gray-200');
                        this.classList.add('border-teal-600', 'bg-teal-100', 'ring-2', 'ring-teal-300');

                        // Set Hidden Input
                        scheduleInput.value = this.dataset.id;
                        
                        // Set Expected Day untuk Validasi Tanggal
                        expectedDay = this.dataset.day;
                        
                        // Tampilkan Badge Hari di form Tanggal
                        finalSection.classList.remove('hidden');
                        targetDayBadge.innerText = `Jadwal: Hari ${expectedDay}`;
                        targetDayBadge.classList.remove('hidden');
                        
                        // Reset Tanggal jika hari tidak cocok (opsional, biar user pilih ulang)
                        validateDate();
                    });

                    scheduleOptions.appendChild(card);
                });
            });
    }

    // --- VALIDASI TANGGAL VIA JAVASCRIPT ---
    dateInput.addEventListener('change', validateDate);

    function validateDate() {
        if(!dateInput.value || !expectedDay) return;

        const selectedDate = new Date(dateInput.value);
        const dayIndex = selectedDate.getDay(); // 0 = Minggu, 1 = Senin, ...
        
        // Mapping Hari JS (0-6) ke Hari Database (Indonesia)
        const daysMap = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const selectedDayName = daysMap[dayIndex];

        if(selectedDayName !== expectedDay) {
            alert(`⚠️ TANGGAL TIDAK VALID!\n\nAnda memilih tanggal hari: ${selectedDayName}.\nJadwal dokter yang Anda pilih hanya tersedia hari: ${expectedDay}.\n\nSilakan pilih tanggal lain.`);
            dateInput.value = ''; // Reset input tanggal
        }
    }
</script>

<style>
    .animate-fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection