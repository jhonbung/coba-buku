<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'NOTONEGORO10',
                'name' => 'Diskon 10% Spesial Pembaca Setia',
                'description' => 'Potongan 10% untuk seluruh novel fisik dan e-book semesta Bianca Veana.',
                'type' => 'percent',
                'value' => 10,
                'min_spend' => 100000,
                'max_discount' => 50000,
                'usage_limit' => 500,
                'is_active' => true,
                'is_public' => true,
                'expires_at' => now()->addMonths(3),
            ],
            [
                'code' => 'ROYAL20K',
                'name' => 'Voucher Royal Pembelian Pertama',
                'description' => 'Potongan langsung Rp 20.000 dengan minimal pembelanjaan Rp 150.000.',
                'type' => 'fixed',
                'value' => 20000,
                'min_spend' => 150000,
                'max_discount' => null,
                'usage_limit' => 300,
                'is_active' => true,
                'is_public' => true,
                'expires_at' => now()->addMonths(2),
            ],
            [
                'code' => 'BEBASONGKIR',
                'name' => 'Subsidi Ongkir Nusantara',
                'description' => 'Potongan ongkos kirim Rp 15.000 dengan ekspedisi resmi (J&T, SiCepat, JNE).',
                'type' => 'shipping',
                'value' => 15000,
                'min_spend' => 150000,
                'max_discount' => null,
                'usage_limit' => 200,
                'is_active' => true,
                'is_public' => true,
                'expires_at' => now()->addMonths(2),
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], $data);
        }
    }
}

