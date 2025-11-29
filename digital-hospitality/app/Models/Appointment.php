<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 
        'doctor_id', 
        'poli_id', 
        'schedule_id', 
        'date', 
        'complaint', 
        'status', 
        'rejection_reason'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}