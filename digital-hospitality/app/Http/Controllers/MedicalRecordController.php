<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    // --- METHOD INDEX (Ini yang hilang sebelumnya) ---
    public function index()
    {
        $user = auth()->user();

        if ($user->isDoctor()) {
            // Jika Dokter: Tampilkan rekam medis yang DIA buat
            $records = $user->medicalRecordsAsDoctor;
        } elseif ($user->isPatient()) {
            // Jika Pasien: Tampilkan riwayat penyakit DIA sendiri
            $records = $user->medicalRecordsAsPatient;
        } else {
            // Jika Admin coba akses, atau role lain
            abort(403);
        }

        // Pastikan file view ini ada di: resources/views/medical-records/index.blade.php
        return view('medical-records.index', compact('records'));
    }

    // --- METHOD CREATE ---
    public function create(Appointment $appointment)
    {
        // Validasi: Hanya dokter yg bersangkutan & status appointment harus approved
        if (!auth()->user()->isDoctor() || $appointment->doctor_id != auth()->id() || $appointment->status != 'approved') {
            abort(403);
        }

        $medicines = Medicine::where('stock', '>', 0)->get(); // Hanya ambil obat yang ada stoknya
        
        // Pastikan file view ini ada di: resources/views/doctor/medical-records/create.blade.php
        return view('doctor.medical-records.create', compact('appointment', 'medicines'));
    }

    // --- METHOD STORE ---
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

        // Simpan Data Rekam Medis
        $record = MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => auth()->id(),
            'diagnosis' => $validated['diagnosis'],
            'treatment' => $validated['treatment'],
            'notes' => $validated['notes'],
            'date' => $validated['date'],
        ]);

        // Simpan Resep Obat & Kurangi Stok
        if (isset($validated['medicines'])) {
            foreach ($validated['medicines'] as $med) {
                // Simpan ke tabel pivot prescription
                Prescription::create([
                    'medical_record_id' => $record->id,
                    'medicine_id' => $med['id'],
                    'quantity' => $med['quantity'],
                ]);

                // Kurangi stok obat
                $medicine = Medicine::find($med['id']);
                if($medicine) {
                    $medicine->decrement('stock', $med['quantity']);
                }
            }
        }

        // Update status appointment jadi Selesai
        $appointment->update(['status' => 'completed']);

        // Redirect ke index (arsip)
        return redirect()->route('medical-records.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    // --- METHOD SHOW ---
    public function show(MedicalRecord $medicalRecord)
    {
        $this->authorizeMedicalRecord($medicalRecord);
        
        // Pastikan file view ini ada di: resources/views/medical-records/show.blade.php
        return view('medical-records.show', compact('medicalRecord'));
    }

    // --- METHOD EDIT ---
    public function edit(MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->isDoctor() || $medicalRecord->doctor_id != auth()->id()) abort(403);
        
        $medicines = Medicine::all();
        // Pastikan file view ini ada di: resources/views/doctor/medical-records/edit.blade.php
        return view('doctor.medical-records.edit', compact('medicalRecord', 'medicines'));
    }

    // --- METHOD UPDATE ---
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

        // Update prescriptions: Kembalikan stok lama, hapus resep lama, simpan resep baru
        
        // 1. Kembalikan stok obat dari resep lama (Restock)
        foreach($medicalRecord->prescriptions as $oldPrescription) {
            $medicine = Medicine::find($oldPrescription->medicine_id);
            if($medicine) {
                $medicine->increment('stock', $oldPrescription->quantity);
            }
        }
        
        // 2. Hapus data di tabel prescription
        $medicalRecord->prescriptions()->delete();

        // 3. Simpan data baru dan kurangi stok lagi
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

    // --- METHOD DESTROY ---
    public function destroy(MedicalRecord $medicalRecord)
    {
        if (!auth()->user()->isDoctor() || $medicalRecord->doctor_id != auth()->id()) abort(403);
        
        // Kembalikan stok obat sebelum dihapus
        foreach($medicalRecord->prescriptions as $pres) {
             $medicine = Medicine::find($pres->medicine_id);
             if($medicine) $medicine->increment('stock', $pres->quantity);
        }

        $medicalRecord->delete();
        return redirect()->route('medical-records.index')->with('success', 'Rekam medis dihapus.');
    }

    // --- HELPER AUTHORIZATION ---
    private function authorizeMedicalRecord(MedicalRecord $medicalRecord)
    {
        $user = auth()->user();
        // Boleh lihat jika: Admin, Dokter yg menangani, atau Pasien ybs
        if ($user->isAdmin() ||
            ($user->isDoctor() && $medicalRecord->doctor_id == $user->id) ||
            ($user->isPatient() && $medicalRecord->patient_id == $user->id)) {
            return true;
        }
        abort(403);
    }
}