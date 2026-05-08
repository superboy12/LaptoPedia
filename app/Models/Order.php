<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'order_number',
        'user_id',
        'total_price',
        'status',
        'phone',
        'address',
        'payment_method',
        'cart_data',
        'payment_proof',
        'notes',
    ];
    
    protected $casts = [
        'cart_data' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}