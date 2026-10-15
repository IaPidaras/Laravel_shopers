<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'id';
    
    public $timestamps = false; 

    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'login',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];
}
