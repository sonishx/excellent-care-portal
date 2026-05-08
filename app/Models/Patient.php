<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'patient_code',
        'full_name',
        'assigned_staff',
        'care_plan',
        'last_update',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function careNotes()
    {
        return $this->hasMany(CareNote::class);
    }

    public function assignedStaff()
    {
        return $this->belongsToMany(User::class, 'patient_staff_assignments', 'patient_id', 'staff_id')
                    ->withPivot('assignment_type')
                    ->withTimestamps();
    }
}