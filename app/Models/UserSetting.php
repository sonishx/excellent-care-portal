<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'email_notifications',
        'push_notifications',
        'sms_alerts',
        'digest_frequency',
        'text_size',
        'high_contrast',
        'reduce_motion',
    ];
}