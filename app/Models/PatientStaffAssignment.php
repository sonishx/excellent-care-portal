<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientStaffAssignment extends Model
{
    protected $fillable = [
        'patient_id',
        'staff_id',
        'assignment_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
