@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Daftar Janji Temu') }}
    </h2>
@endsection

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-teal-700">Riwayat & Antrian</h3>
            @if(auth()->user()->isPatient())
            <a href="{{ route('appointments.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Janji Baru
            </a>
            @endif
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-teal-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Info Janji Temu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-800 uppercase tracking-wider">Dokter & Poli</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-teal-800 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-teal-800 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">
                                <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $appointment->schedule->day ?? '-' }}</span>
                                <span class="ml-1">{{ $appointment->schedule ? \Carbon\Carbon::parse($appointment->schedule->start_time)->format('H:i') : '-' }} WIB</span>
                            </div>
                            @if(auth()->user()->role !== 'patient')
                            <div class="text-xs text-indigo-600 mt-1 font-semibold">Pasien: {{ $appointment->patient->name }}</div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $appointment->doctor->name }}</div>
                            <div class="text-xs text-teal-600">{{ $appointment->doctor->poli->name ?? 'Poli Umum' }}</div>
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($appointment->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    Pending
                                </span>
                            @elseif($appointment->status == 'approved')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    Approved
                                </span>
                            @elseif($appointment->status == 'completed')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    Selesai
                                </span>
                            @elseif($appointment->status == 'rejected')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex justify-center items-center space-x-3">
                                {{-- VIEW DETAIL (All) --}}
                                <a href="{{ route('appointments.show', $appointment) }}" class="text-teal-600 hover:text-teal-900 bg-teal-50 p-2 rounded-full hover:bg-teal-100" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>

                                {{-- ACTION: PATIENT (Edit/Delete if Pending) --}}
                                @if($appointment->status == 'pending' && auth()->user()->isPatient() && $appointment->patient_id == auth()->id())
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="text-yellow-600 hover:text-yellow-900 bg-yellow-50 p-2 rounded-full hover:bg-yellow-100" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan janji ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-full hover:bg-red-100" title="Batalkan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- ACTION: ADMIN/DOCTOR (Approve/Reject) --}}
                                @if($appointment->status == 'pending' && (auth()->user()->isAdmin() || (auth()->user()->isDoctor() && $appointment->doctor_id == auth()->id())))
                                    <form action="{{ route('appointments.approve', $appointment) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 p-2 rounded-full hover:bg-green-100" title="Terima">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('appointments.reject', $appointment) }}" method="POST" class="flex items-center">
                                        @csrf
                                        <input type="text" name="rejection_reason" placeholder="Alasan..." required class="text-xs border-gray-300 rounded-l-md w-20 focus:ring-red-500 focus:border-red-500">
                                        <button type="submit" class="bg-red-600 text-white p-1.5 rounded-r-md hover:bg-red-700 text-xs" title="Tolak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                @endif

                                {{-- ACTION: DOCTOR (Create Medical Record if Approved) --}}
                                @if($appointment->status == 'approved' && auth()->user()->isDoctor() && $appointment->doctor_id == auth()->id())
                                    <a href="{{ route('medical-records.create', $appointment) }}" class="text-purple-600 hover:text-purple-900 bg-purple-50 px-3 py-1 rounded-full text-xs font-bold hover:bg-purple-100 flex items-center">
                                        + Periksa
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data janji temu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection