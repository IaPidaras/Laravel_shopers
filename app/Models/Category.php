<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Указываем таблицу категорий из вашего SQL-дампа
    protected $table = 'categories';

    // Указываем первичный ключ
    protected $primaryKey = 'id_category';

    // Разрешаем массовое заполнение для имени категории
    protected $fillable = [
        'name',
    ];

    // Отключаем автоматические timestamps (в таблице categories их нет)
    public $timestamps = false;

    /**
     * Связь с товарами (У одной категории может быть много товаров)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'id_category', 'id_category');
    }
}
