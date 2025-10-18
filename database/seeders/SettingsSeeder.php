<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // General Settings
        $generalSettings = [
            [
                'key' => 'company_name',
                'name' => 'Nama Perusahaan',
                'value' => 'Bazaar Jakarta',
                'description' => 'Nama perusahaan yang akan ditampilkan di website',
                'type' => 'text',
                'category' => 'general',
                'order' => 1,
            ],
            [
                'key' => 'phone_number',
                'name' => 'No HP',
                'value' => '+62 21 1234 5678',
                'description' => 'Nomor telepon perusahaan',
                'type' => 'tel',
                'category' => 'general',
                'order' => 2,
            ],
            [
                'key' => 'whatsapp_number',
                'name' => 'No WhatsApp',
                'value' => '+628123456789',
                'description' => 'Nomor WhatsApp untuk kontak',
                'type' => 'tel',
                'category' => 'general',
                'order' => 3,
            ],
            [
                'key' => 'address',
                'name' => 'Alamat',
                'value' => 'Palmer Cine Jl. Raya Rambu Auas, Kota Jakarta',
                'description' => 'Alamat perusahaan',
                'type' => 'text',
                'category' => 'general',
                'order' => 4,
            ],
            [
                'key' => 'email',
                'name' => 'Email',
                'value' => 'info@bazaarjakarta.id',
                'description' => 'Email perusahaan',
                'type' => 'email',
                'category' => 'general',
                'order' => 5,
            ],
            [
                'key' => 'description',
                'name' => 'Deskripsi',
                'value' => 'BazaarJakarta.ID di bawah PT. Kreatif Jakarta Indotama adalah perusahaan di bidang event organizer, event production, sewa tenda, digital campaign, expo, concert, corporate event, dan kegiatan kreatif lainnya.',
                'description' => 'Deskripsi perusahaan',
                'type' => 'textarea',
                'category' => 'general',
                'order' => 6,
            ],
            [
                'key' => 'vision',
                'name' => 'Visi',
                'value' => 'Menjadi penyelenggara event terdepan di Indonesia yang menghubungkan UMKM dengan konsumen',
                'description' => 'Visi perusahaan',
                'type' => 'textarea',
                'category' => 'general',
                'order' => 7,
            ],
            [
                'key' => 'mission',
                'name' => 'Misi',
                'value' => 'Menyediakan platform bazaar yang inovatif, mendukung UMKM lokal, dan menciptakan pengalaman berbelanja yang unik',
                'description' => 'Misi perusahaan',
                'type' => 'textarea',
                'category' => 'general',
                'order' => 8,
            ],
            [
                'key' => 'facebook',
                'name' => 'Facebook',
                'value' => 'https://facebook.com/bazaarjakarta',
                'description' => 'Link Facebook',
                'type' => 'url',
                'category' => 'general',
                'order' => 9,
            ],
            [
                'key' => 'instagram',
                'name' => 'Instagram',
                'value' => 'https://instagram.com/bazaarjakarta',
                'description' => 'Link Instagram',
                'type' => 'url',
                'category' => 'general',
                'order' => 10,
            ],
            [
                'key' => 'tiktok',
                'name' => 'TikTok',
                'value' => 'https://tiktok.com/@bazaarjakarta',
                'description' => 'Link TikTok',
                'type' => 'url',
                'category' => 'general',
                'order' => 11,
            ],
            [
                'key' => 'youtube',
                'name' => 'YouTube',
                'value' => 'https://youtube.com/bazaarjakarta',
                'description' => 'Link YouTube',
                'type' => 'url',
                'category' => 'general',
                'order' => 12,
            ],
            [
                'key' => 'twitter',
                'name' => 'Twitter',
                'value' => 'https://twitter.com/bazaarjakarta',
                'description' => 'Link Twitter',
                'type' => 'url',
                'category' => 'general',
                'order' => 13,
            ],
        ];

        // SEO Settings
        $seoSettings = [
            [
                'key' => 'google_site_verification',
                'name' => 'Google Site Verification',
                'value' => '',
                'description' => 'Kode verifikasi dari Google Search Console',
                'type' => 'text',
                'category' => 'seo',
                'order' => 1,
            ],
            [
                'key' => 'home_image',
                'name' => 'Image Home',
                'value' => '',
                'description' => 'Gambar untuk halaman utama',
                'type' => 'image',
                'category' => 'seo',
                'order' => 2,
            ],
            [
                'key' => 'seo_keywords',
                'name' => 'SEO Keywords',
                'value' => 'Bazaar Jakarta, Event Bazaar, Jual Beli, UMKM, Pasar Lokal, Komunitas',
                'description' => 'Kata kunci SEO untuk mesin pencari',
                'type' => 'text',
                'category' => 'seo',
                'order' => 3,
            ],
            [
                'key' => 'seo_description',
                'name' => 'SEO Description',
                'value' => 'Bazaar Jakarta adalah platform bazaar online terbesar di Jakarta untuk jual beli produk lokal dan event komunitas. Temukan produk unik dan ikuti event menarik di kota Anda.',
                'description' => 'Deskripsi SEO untuk mesin pencari',
                'type' => 'textarea',
                'category' => 'seo',
                'order' => 4,
            ],
        ];

        // Homepage Settings
        $homepageSettings = [
            [
                'key' => 'stat_event_sukses',
                'name' => 'Event Sukses',
                'value' => '200+',
                'description' => 'Jumlah event sukses yang telah diselenggarakan',
                'type' => 'text',
                'category' => 'homepage',
                'order' => 1,
            ],
            [
                'key' => 'stat_peserta',
                'name' => 'Peserta',
                'value' => '50K+',
                'description' => 'Total jumlah peserta yang telah bergabung',
                'type' => 'text',
                'category' => 'homepage',
                'order' => 2,
            ],
            [
                'key' => 'stat_partner_bisnis',
                'name' => 'Partner Bisnis',
                'value' => '100+',
                'description' => 'Jumlah partner bisnis yang bekerja sama',
                'type' => 'text',
                'category' => 'homepage',
                'order' => 3,
            ],
            [
                'key' => 'stat_penghargaan',
                'name' => 'Penghargaan',
                'value' => '15',
                'description' => 'Jumlah penghargaan yang telah diraih',
                'type' => 'text',
                'category' => 'homepage',
                'order' => 4,
            ],
        ];

        // Insert all settings using updateOrInsert to avoid duplicates
        $allSettings = array_merge($generalSettings, $seoSettings, $homepageSettings);
        
        foreach ($allSettings as $setting) {
            Setting::updateOrInsert(
                ['key' => $setting['key']],
                [
                    'name' => $setting['name'],
                    'value' => $setting['value'],
                    'description' => $setting['description'],
                    'type' => $setting['type'],
                    'category' => $setting['category'],
                    'order' => $setting['order'],
                ]
            );
        }
    }
}