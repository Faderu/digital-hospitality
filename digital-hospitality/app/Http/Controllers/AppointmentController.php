<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Poli;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $query = Appointment::with(['doctor', 'patient', 'schedule', 'poli']);

        if ($user->isAdmin()) {
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
        } elseif ($user->isDoctor()) {
            $query->where('doctor_id', $user->id);
        } elseif ($user->isPatient()) {
            $query->where('patient_id', $user->id);
        } else {
            abort(403);
        }

        $appointments = $query->latest()->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        if (!auth()->user()->isPatient()) abort(403);
        $polis = Poli::all();
        return view('patient.appointments.create', compact('polis'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isPatient()) abort(403);

        $validated = $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:users,id,role,doctor',
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date|after_or_equal:today',
            'complaint' => 'nullable|string|max:1000',
        ]);

        $doctor = User::find($validated['doctor_id']);
        if ($doctor->poli_id != $validated['poli_id']) {
            return back()->withErrors(['doctor_id' => 'Dokter tidak termasuk dalam poli yang dipilih.']);
        }

        $schedule = Schedule::find($validated['schedule_id']);
        if ($schedule->doctor_id != $validated['doctor_id']) {
            return back()->withErrors(['schedule_id' => 'Jadwal tidak milik dokter yang dipilih.']);
        }

        // --- FIX: VALIDASI HARI ---
        // Mapping hari Inggris (dari fungsi date PHP) ke Indonesia (sesuai database Schedule)
        $dayMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        
        $chosenDayEnglish = date('l', strtotime($validated['date']));
        $chosenDayIndo = $dayMap[$chosenDayEnglish] ?? null;

        if ($chosenDayIndo !== $schedule->day) {
            return back()->withErrors(['date' => "Tanggal yang Anda pilih adalah hari $chosenDayIndo, sedangkan jadwal dokter ini hanya tersedia pada hari $schedule->day."]);
        }
        // --------------------------

        $existing = Appointment::where('schedule_id', $validated['schedule_id'])
            ->where('date', $validated['date'])
            ->exists();
            
        // Catatan: Jika Anda ingin 1 slot bisa banyak pasien (antrian), hapus validasi $existing ini.
        // Jika 1 slot = 1 pasien, biarkan kode ini.
        if ($existing) {
             // return back()->withErrors(['date' => 'Slot waktu ini sudah dipesan.']); 
             // Untuk rumah sakit biasanya 1 jadwal bisa banyak pasien (antrian), 
             // jadi logic ini mungkin perlu Anda pertimbangkan untuk dihapus/disesuaikan.
        }

        $validated['patient_id'] = auth()->id();
        $validated['status'] = 'pending';

        Appointment::create($validated);
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully');
    }

    public function show(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        if (!auth()->user()->isPatient() || $appointment->patient_id != auth()->id() || $appointment->status != 'pending') abort(403);
        $polis = Poli::all();
        return view('patient.appointments.edit', compact('appointment', 'polis'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (!auth()->user()->isPatient() || $appointment->patient_id != auth()->id() || $appointment->status != 'pending') abort(403);

        $validated = $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'doctor_id' => 'required|exists:users,id,role,doctor',
            'schedule_id' => 'required|exists:schedules,id',
            'date' => 'required|date|after_or_equal:today',
            'complaint' => 'nullable|string|max:1000',
        ]);

        // Validasi Hari juga perlu dilakukan di Update
        $schedule = Schedule::find($validated['schedule_id']);
        $dayMap = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $chosenDayEnglish = date('l', strtotime($validated['date']));
        $chosenDayIndo = $dayMap[$chosenDayEnglish] ?? null;

        if ($chosenDayIndo !== $schedule->day) {
             return back()->withErrors(['date' => "Tanggal tidak sesuai dengan hari jadwal dokter ($schedule->day)."]);
        }

        $appointment->update($validated);
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully');
    }

    public function destroy(Appointment $appointment)
    {
        if (!auth()->user()->isPatient() || $appointment->patient_id != auth()->id() || $appointment->status != 'pending') abort(403);
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully');
    }

    public function approve(Appointment $appointment)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || ($user->isDoctor() && $appointment->doctor_id == $user->id))) abort(403);
        if ($appointment->status != 'pending') abort(400, 'Appointment sudah diproses.');

        $appointment->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Appointment approved');
    }

    public function reject(Request $request, Appointment $appointment)
    {
        $user = auth()->user();
        if (!($user->isAdmin() || ($user->isDoctor() && $appointment->doctor_id == $user->id))) abort(403);
        if ($appointment->status != 'pending') abort(400, 'Appointment sudah diproses.');

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $appointment->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);
        return redirect()->back()->with('success', 'Appointment rejected');
    }

    private function authorizeAppointment(Appointment $appointment)
    {
        $user = auth()->user();
        if ($user->isAdmin() ||
            ($user->isDoctor() && $appointment->doctor_id == $user->id) ||
            ($user->isPatient() && $appointment->patient_id == $user->id)) {
            return true;
        }
        abort(403);
    }
}