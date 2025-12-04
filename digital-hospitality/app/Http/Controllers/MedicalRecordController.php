<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isDoctor()) {
            $records = $user->medicalRecordsAsDoctor;
        } elseif ($user->isPatient()) {
            $records = $user->medicalRecordsAsPatient;
        } else {
            abort(403);
        }
        return view('medical-records.index', compact('records'));
    }

    public function create(Appointment $appointment)
    {
        if (!auth()->user()->isDoctor() || $appointment->doctor_id != auth()->id() || $appointment->status != 'approved') {
            abort(403);
        }

        $medicines = Medicine::where('stock', '>', 0)->get();
        
        return view('doctor.medical-records.create', compact('appointment', 'medicines'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        if (!auth()->user()->isDoctor() || $appointment->doctor_id != auth()->id() || $appointment->status != 'approved') {
            abort(403);
        }

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'date' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'exists:medicines,id',
            'medicines.*.quantity' => 'integer|min:1',
        ]);

        $record = MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => auth()->id(),
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'notes' => $validated['notes'],
            'date' => $validated['date'],
        ]);

        if (isset($validated['medicines'])) {
            foreach ($validated['medicines'] as $med) {
                Prescription::create([
                    'medical_record_id' => $record->id,
                    'medicine_id' => $med['id'],
                    'quantity' => $med['quantity'],
                ]);

                $medicine = Medicine::find($med['id']);
                if($medicine) {
                    $medicine->decrement('stock', $med['quantity']);
                }
            }
        }

        $appointment->update(['status' => 'completed']);

        return redirect()->route('medical-records.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $this->authorizeMedicalRecord($medicalRecord);

        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->isDoctor() || $medicalRecord->doctor_id != auth()->id()) abort(403);
        
        $medicines = Medicine::all();
        return view('doctor.medical-records.edit', compact('medicalRecord', 'medicines'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->isDoctor() || $medicalRecord->doctor_id != auth()->id()) abort(403);

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'notes' => 'nullable|string',
            'date' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'exists:medicines,id',
            'medicines.*.quantity' => 'integer|min:1',
        ]);

        $medicalRecord->update([
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'notes' => $validated['notes'],
            'date' => $validated['date'],
        ]);

        foreach($medicalRecord->prescriptions as $oldPrescription) {
            $medicine = Medicine::find($oldPrescription->medicine_id);
            if($medicine) {
                $medicine->increment('stock', $oldPrescription->quantity);
            }
        }

        $medicalRecord->prescriptions()->delete();

        if (isset($validated['medicines'])) {
            foreach ($validated['medicines'] as $med) {
                Prescription::create([
                    'medical_record_id' => $medicalRecord->id,
                    'medicine_id' => $med['id'],
                    'quantity' => $med['quantity'],
                ]);

                $medicine = Medicine::find($med['id']);
                if($medicine) {
                    $medicine->decrement('stock', $med['quantity']);
                }
            }
        }

        return redirect()->route('medical-records.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->isDoctor() || $medicalRecord->doctor_id != auth()->id()) abort(403);

        foreach($medicalRecord->prescriptions as $pres) {
             $medicine = Medicine::find($pres->medicine_id);
             if($medicine) $medicine->increment('stock', $pres->quantity);
        }

        $medicalRecord->delete();
        return redirect()->route('medical-records.index')->with('success', 'Rekam medis dihapus.');
    }

    private function authorizeMedicalRecord(MedicalRecord $medicalRecord)
    {
        $user = auth()->user();
        if ($user->isAdmin() ||
            ($user->isDoctor() && $medicalRecord->doctor_id == $user->id) ||
            ($user->isPatient() && $medicalRecord->patient_id == $user->id)) {
            return true;
        }
        abort(403);
    }
}