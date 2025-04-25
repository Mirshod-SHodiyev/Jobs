<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Sayt_users extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'sayt_users'; // agar table nomi default "sayt_users" bo'lsa, bu kerak emas

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

