<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'phone',
        'address',
        'latitude',
        'longitude',
        'payment_method',
        'snap_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
