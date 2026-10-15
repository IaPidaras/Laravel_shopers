<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Задаем имя таблицы и её первичный ключ из твоего дампа бд
    protected $table = 'carts';
    protected $primaryKey = 'id_cart';

    protected $fillable = ['id_user', 'id_product', 'count'];
    public $timestamps = false; // У тебя в дампе нет колонок updated_at/created_at для корзины

    // Связь: Каждая запись в корзине жестко связана с одним товаром (принтером)
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
