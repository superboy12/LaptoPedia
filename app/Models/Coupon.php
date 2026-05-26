<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'expires_at',
        'is_active',
        'usage_limit',
        'used_count',
        'description',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_active'  => 'boolean',
    ];

    /**
     * Periksa apakah kupon masih valid untuk total belanja tertentu.
     * Return array ['valid' => bool, 'message' => string, 'discount' => int]
     */
    public function validate(int $total): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Kupon tidak aktif.', 'discount' => 0];
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return ['valid' => false, 'message' => 'Kupon sudah kedaluwarsa.', 'discount' => 0];
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Kupon sudah mencapai batas penggunaan.', 'discount' => 0];
        }

        if ($this->min_purchase && $total < $this->min_purchase) {
            return [
                'valid'    => false,
                'message'  => 'Minimum pembelian Rp ' . number_format($this->min_purchase, 0, ',', '.') . ' untuk menggunakan kupon ini.',
                'discount' => 0,
            ];
        }

        $discount = $this->calculateDiscount($total);

        return [
            'valid'    => true,
            'message'  => 'Kupon berhasil diterapkan!',
            'discount' => $discount,
        ];
    }

    /**
     * Hitung nilai diskon berdasarkan tipe kupon.
     */
    public function calculateDiscount(int $total): int
    {
        if ($this->type === 'fixed') {
            return (int) min($this->value, $total);
        }

        // type === 'percent'
        $discount = (int) round($total * $this->value / 100);

        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }

        return $discount;
    }

    /**
     * Tambah counter pemakaian kupon.
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
