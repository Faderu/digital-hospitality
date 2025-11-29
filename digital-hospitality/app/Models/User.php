<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'poli_id'];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'doctor_id');
    }

    public function appointmentsAsDoctor()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    public function appointmentsAsPatient()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function medicalRecordsAsDoctor()
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    public function medicalRecordsAsPatient()
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'patient_id');
    }

    // Helper untuk check role
    public function isAdmin() { return $this->role === 'admin'; }
    public function isDoctor() { return $this->role === 'doctor'; }
    public function isPatient() { return $this->role === 'patient'; }
}