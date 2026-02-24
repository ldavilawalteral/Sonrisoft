<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'tenant_id',
        'treatment_id',
        'status',
        'scheduled_at',
        'symptoms',
        'vital_signs',
        'notes',
        'triage_alergy',
        'triage_pain_level',
        'triage_notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class , 'doctor_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
