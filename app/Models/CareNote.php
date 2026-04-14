<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'note',
    ];

    // CareNote belongs to a Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // CareNote belongs to a User (caregiver)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}