<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'        => 'LAPTOP500K',
                'type'        => 'fixed',
                'value'       => 500000,
                'min_purchase' => 10000000,
                'max_discount' => null,
                'expires_at'  => '2026-06-30',
                'is_active'   => true,
                'usage_limit' => null,
                'description' => 'Diskon Rp 500.000 untuk pembelian laptop minimum Rp 10.000.000',
            ],
            [
                'code'        => 'FREESHIPID',
                'type'        => 'fixed',
                'value'       => 0,
                'min_purchase' => null,
                'max_discount' => null,
                'expires_at'  => '2026-07-15',
                'is_active'   => true,
                'usage_limit' => null,
                'description' => 'Gratis Ongkir Se-Indonesia untuk semua produk tanpa minimum pembelian',
            ],
            [
                'code'        => 'PEDIA10EDU',
                'type'        => 'percent',
                'value'       => 10,
                'min_purchase' => null,
                'max_discount' => 500000,
                'expires_at'  => '2026-12-31',
                'is_active'   => true,
                'usage_limit' => null,
                'description' => 'Student Discount 10% (maksimal Rp 500.000) untuk pelajar & mahasiswa',
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}
