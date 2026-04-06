<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_code',
        'full_name',
        'assigned_staff',
        'care_plan',
        'last_update',
        'status',
    ];
}