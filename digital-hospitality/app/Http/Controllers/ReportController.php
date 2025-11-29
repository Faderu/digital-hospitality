<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // FIX: Join langsung ke Polis melalui appointment.poli_id agar data historis akurat
        $patientsPerPoli = Appointment::select('polis.name', DB::raw('count(distinct patient_id) as patient_count'))
            ->join('polis', 'appointments.poli_id', '=', 'polis.id')
            ->groupBy('polis.id', 'polis.name')
            ->get();

        $doctorPerformance = User::where('role', 'doctor')
            ->select('users.name', DB::raw('count(appointments.id) as completed_appointments'))
            ->leftJoin('appointments', 'users.id', '=', 'appointments.doctor_id')
            ->where('appointments.status', 'completed')
            ->groupBy('users.id', 'users.name')
            ->get();

        $medicineUsage = Medicine::select('medicines.name', DB::raw('sum(prescriptions.quantity) as total_used'))
            ->leftJoin('prescriptions', 'medicines.id', '=', 'prescriptions.medicine_id')
            ->groupBy('medicines.id', 'medicines.name')
            ->get();

        return view('admin.reports.index', compact('patientsPerPoli', 'doctorPerformance', 'medicineUsage'));
    }
}