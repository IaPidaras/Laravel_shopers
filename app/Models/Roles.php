<?php
namespace App\models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Roles extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'id_role',
    ];
}

