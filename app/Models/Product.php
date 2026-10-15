<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Указываем Laravel первичный ключ, так как он отличается от дефолтного "id"
    protected $primaryKey = 'id_product';

    // Разрешаем массовое сохранение полей из таблицы бд
    protected $fillable = [
        'name',
        'cost',
        'country',
        'year',
        'model',
        'img',
        'id_category',
        'count'
    ];

    // Отключаем автоматические timestamps (updated_at), если их нет в структуре таблицы
    public $timestamps = false; 
}
