<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_status',
        'reason'
    ];

    // ДОБАВЛЯЕМ АВТОМАТИЧЕСКОЕ ПРИВЕДЕНИЕ СТРОКИ К ОБЪЕКТУ ДАТЫ
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status', 'id_status');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'id_order', 'id_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
