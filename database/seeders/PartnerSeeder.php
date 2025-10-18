<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Tokopedia',
                'logo' => 'images/partners/tokopedia.png',
                'website' => 'https://www.tokopedia.com',
                'description' => 'Leading e-commerce platform in Indonesia',
                'order_number' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Gojek',
                'logo' => 'images/partners/gojek.png',
                'website' => 'https://www.gojek.com',
                'description' => 'Super app providing various services',
                'order_number' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Bank BCA',
                'logo' => 'images/partners/bca.png',
                'website' => 'https://www.klikbca.com',
                'description' => 'Leading private bank in Indonesia',
                'order_number' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Telkomsel',
                'logo' => 'images/partners/telkomsel.png',
                'website' => 'https://www.telkomsel.com',
                'description' => 'Largest telecommunications provider in Indonesia',
                'order_number' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Indomaret',
                'logo' => 'images/partners/indomaret.png',
                'website' => 'https://www.indomaret.co.id',
                'description' => 'Leading convenience store chain in Indonesia',
                'order_number' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Shopee',
                'logo' => 'images/partners/shopee.png',
                'website' => 'https://www.shopee.co.id',
                'description' => 'Leading e-commerce platform in Southeast Asia',
                'order_number' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Dana',
                'logo' => 'images/partners/dana.png',
                'website' => 'https://www.dana.id',
                'description' => 'Leading digital wallet in Indonesia',
                'order_number' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Bukalapak',
                'logo' => 'images/partners/bukalapak.png',
                'website' => 'https://www.bukalapak.com',
                'description' => 'Leading e-commerce platform in Indonesia',
                'order_number' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }
    }
}