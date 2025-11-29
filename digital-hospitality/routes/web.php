<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\PoliController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Models\Poli;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/polis', function () {
    $polis = Poli::all();
    return view('public.polis', compact('polis'));
})->name('public.polis');

Route::get('/doctors', function () {
    $doctors = User::where('role', 'doctor')->with('poli', 'schedules')->get();
    return view('public.doctors', compact('doctors'));
})->name('public.doctors');

Route::get('/doctors/{doctor}', function (User $doctor) {
    if (!$doctor->isDoctor()) abort(404);
    return view('public.doctor-profile', compact('doctor'));
})->name('public.doctor.profile');

// --- GUEST REDIRECT ---
// FIX: Mengarahkan tombol "Masuk sebagai Tamu" langsung ke Daftar Dokter
Route::get('/guest', function () {
    return redirect()->route('public.doctors'); 
})->name('guest');


// --- AUTHENTICATED ROUTES ---
Route::middleware('auth')->group(function () {

    // 1. DASHBOARD REDIRECTS (Sesuai Controller Login)
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isDoctor()) return redirect()->route('doctor.dashboard');
        if ($user->isPatient()) return redirect()->route('patient.dashboard');
        abort(403);
    })->name('dashboard');

    // 2. ROLE SPECIFIC DASHBOARDS
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard'); 
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/doctor/dashboard', function () {
        return view('doctor.dashboard'); 
    })->middleware('role:doctor')->name('doctor.dashboard');

    Route::get('/patient/dashboard', function () {
        return view('patient.dashboard'); 
    })->middleware('role:patient')->name('patient.dashboard');


    // 3. ADMIN RESOURCES
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('polis', PoliController::class);
        Route::resource('medicines', MedicineController::class);
        Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    });

    // 4. DOCTOR RESOURCES
    Route::middleware('role:doctor')->group(function () {
        Route::resource('schedules', ScheduleController::class);
        // Medical Record Operations (Create, Store, Edit, Update, Delete)
        // Kita gunakan resource biasa, tapi view create/edit ada di folder doctor/medical-records
        Route::get('medical-records/create/{appointment}', [MedicalRecordController::class, 'create'])->name('medical-records.create');
        Route::post('medical-records/{appointment}', [MedicalRecordController::class, 'store'])->name('medical-records.store');
        Route::get('medical-records/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
        Route::put('medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
        Route::delete('medical-records/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    });

    // 5. SHARED & PATIENT RESOURCES
    
    // Appointment (Logic authorization ada di dalam Controller)
    Route::resource('appointments', AppointmentController::class);
    Route::post('appointments/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');

    // Medical Records Read-Only (Index & Show untuk Patient & Doctor)
    // Note: Route create/edit/delete dokter di atas akan menangkap request duluan jika URL spesifik
    Route::get('medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('medical-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');

    // Feedback (Patient Only)
    Route::middleware('role:patient')->group(function () {
        Route::get('/feedback/create/{appointment?}', [FeedbackController::class, 'create'])->name('feedback.create');
        Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
    });

    // 6. PROFILE MANAGEMENT
    Route::get('/profile', function () {
        return view('profile.edit', ['user' => auth()->user()]);
    })->name('profile.edit');
    
    Route::patch('/profile', function (Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update($validated);
        return redirect()->route('profile.edit')->with('success', 'Profile updated');
    })->name('profile.update');

    // 7. API ROUTES (For Ajax/Dynamic Selects)
    Route::get('/api/polis/{poli}/doctors', function (Poli $poli) {
        return response()->json($poli->doctors);
    })->name('api.poli.doctors');

    Route::get('/api/doctors/{doctor}/schedules', function (User $doctor) {
        if (!$doctor->isDoctor()) abort(404);
        return response()->json($doctor->schedules);
    })->name('api.doctor.schedules');
});

require __DIR__.'/auth.php';