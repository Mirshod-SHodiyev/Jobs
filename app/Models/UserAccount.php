<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAccount extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'user_accounts'; 

    protected $fillable = [
        'user_type_id',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'is_active',
        'contact_number',
        'sms_notification_active',
        'email_notification_active',
        'user_image',
        'registration_date',
    ];
 
}
