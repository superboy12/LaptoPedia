<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'name', 
        'slug', 
        'category_id', 
        'price', 
        'description', 
        'stock', 
        'image',
        'spec_title',
        'spec_description',
        'highlights',
        'variations'
    ];
    
    protected $casts = [
        'highlights' => 'array',
        'variations' => 'array',
        'price' => 'integer',
        'stock' => 'integer'
    ];

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    // Relasi ke Cart
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }
    
    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
    
    // Accessor untuk mendapatkan capacities dari variations
    public function getCapacitiesAttribute()
    {
        if (!$this->variations) return [];
        return array_filter($this->variations, function($v) {
            return $v['type'] === 'capacity';
        });
    }
    
    // Accessor untuk mendapatkan colors dari variations
    public function getColorsAttribute()
    {
        if (!$this->variations) return [];
        return array_filter($this->variations, function($v) {
            return $v['type'] === 'color';
        });
    }
}