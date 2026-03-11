<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── HERO ──────────────────────────────────────────────
            ['key' => 'hero_badge_text',    'group' => 'hero', 'label' => 'Teks Badge / Promo Kecil',          'type' => 'text',     'value' => '🎉 Promo spesial — diskon hingga 50%'],
            ['key' => 'hero_title_line1',   'group' => 'hero', 'label' => 'Judul Baris 1',                     'type' => 'text',     'value' => 'Jendela'],
            ['key' => 'hero_title_line2',   'group' => 'hero', 'label' => 'Judul Baris 2 (warna gradient)',    'type' => 'text',     'value' => 'Dunia'],
            ['key' => 'hero_title_line3',   'group' => 'hero', 'label' => 'Judul Baris 3',                     'type' => 'text',     'value' => 'Ada di Sini'],
            ['key' => 'hero_subtitle',      'group' => 'hero', 'label' => 'Sub-judul / Deskripsi Hero',        'type' => 'textarea', 'value' => 'Temukan ribuan buku dari berbagai genre — fiksi, sains, hingga buku anak — dengan harga terjangkau dan pengiriman cepat ke seluruh Indonesia.'],
            ['key' => 'hero_btn1_text',     'group' => 'hero', 'label' => 'Teks Tombol Utama',                 'type' => 'text',     'value' => 'Jelajahi Katalog'],
            ['key' => 'hero_btn2_text',     'group' => 'hero', 'label' => 'Teks Tombol Sekunder',              'type' => 'text',     'value' => 'Lihat Kategori'],

            // Promo Cards Desktop
            ['key' => 'hero_promo1_label',  'group' => 'hero', 'label' => 'Kartu Promo 1 — Label',            'type' => 'text',     'value' => 'Flash Sale'],
            ['key' => 'hero_promo1_value',  'group' => 'hero', 'label' => 'Kartu Promo 1 — Nilai',            'type' => 'text',     'value' => 'Diskon 50%'],
            ['key' => 'hero_promo1_sub',    'group' => 'hero', 'label' => 'Kartu Promo 1 — Sub-teks',         'type' => 'text',     'value' => 'Terbatas hari ini'],
            ['key' => 'hero_promo2_label',  'group' => 'hero', 'label' => 'Kartu Promo 2 — Label',            'type' => 'text',     'value' => 'Gratis Ongkir'],
            ['key' => 'hero_promo2_value',  'group' => 'hero', 'label' => 'Kartu Promo 2 — Nilai',            'type' => 'text',     'value' => 'Min. Rp 50.000'],
            ['key' => 'hero_promo2_sub',    'group' => 'hero', 'label' => 'Kartu Promo 2 — Sub-teks',         'type' => 'text',     'value' => 'Seluruh Indonesia'],
            ['key' => 'hero_promo3_label',  'group' => 'hero', 'label' => 'Kartu Promo 3 — Label',            'type' => 'text',     'value' => 'Member Baru'],
            ['key' => 'hero_promo3_value',  'group' => 'hero', 'label' => 'Kartu Promo 3 — Nilai',            'type' => 'text',     'value' => 'Cashback 10%'],
            ['key' => 'hero_promo3_sub',    'group' => 'hero', 'label' => 'Kartu Promo 3 — Sub-teks',         'type' => 'text',     'value' => 'Pembelian pertama'],

            // ── FITUR / WHY US ────────────────────────────────────
            ['key' => 'feature1_title',     'group' => 'features', 'label' => 'Fitur 1 — Judul',              'type' => 'text',     'value' => 'Pengiriman Kilat'],
            ['key' => 'feature1_desc',      'group' => 'features', 'label' => 'Fitur 1 — Deskripsi',          'type' => 'textarea', 'value' => 'Pesanan dikirim 1–3 hari kerja ke seluruh Indonesia via kurir terpercaya.'],
            ['key' => 'feature2_title',     'group' => 'features', 'label' => 'Fitur 2 — Judul',              'type' => 'text',     'value' => 'Pembayaran Aman'],
            ['key' => 'feature2_desc',      'group' => 'features', 'label' => 'Fitur 2 — Deskripsi',          'type' => 'textarea', 'value' => 'Transaksi 100% aman dengan enkripsi SSL dan berbagai metode pembayaran.'],
            ['key' => 'feature3_title',     'group' => 'features', 'label' => 'Fitur 3 — Judul',              'type' => 'text',     'value' => 'Support 24/7'],
            ['key' => 'feature3_desc',      'group' => 'features', 'label' => 'Fitur 3 — Deskripsi',          'type' => 'textarea', 'value' => 'Tim kami siap membantu kapan saja — chat, email, atau telepon.'],

            // ── CTA SECTION ───────────────────────────────────────
            ['key' => 'cta_title',          'group' => 'cta', 'label' => 'CTA — Judul',                       'type' => 'text',     'value' => 'Siap Membuka Jendela Dunia Baru?'],
            ['key' => 'cta_subtitle',       'group' => 'cta', 'label' => 'CTA — Sub-judul',                   'type' => 'textarea', 'value' => 'Daftar sekarang dan dapatkan diskon 20% untuk pembelian pertama Anda.'],
            ['key' => 'cta_btn_text',       'group' => 'cta', 'label' => 'CTA — Teks Tombol',                 'type' => 'text',     'value' => 'Daftar Gratis'],

            // ── INFORMASI TOKO ────────────────────────────────────
            ['key' => 'store_name',         'group' => 'store', 'label' => 'Nama Toko',                        'type' => 'text',     'value' => 'ATigaBookStore'],
            ['key' => 'store_tagline',      'group' => 'store', 'label' => 'Tagline',                          'type' => 'text',     'value' => 'Jendela Dunia Lewat Buku'],
            ['key' => 'store_description',  'group' => 'store', 'label' => 'Deskripsi Toko',                   'type' => 'textarea', 'value' => 'Toko buku online terpercaya dengan koleksi lengkap dan harga terbaik. Kami berkomitmen memberikan pengalaman berbelanja buku yang menyenangkan dan mudah untuk semua kalangan.'],
            ['key' => 'store_email',        'group' => 'store', 'label' => 'Email',                            'type' => 'email',    'value' => 'info@ATigaBookStore.com'],
            ['key' => 'store_phone',        'group' => 'store', 'label' => 'Nomor Telepon',                    'type' => 'text',     'value' => '+62 123 456 789'],
            ['key' => 'store_whatsapp',     'group' => 'store', 'label' => 'Nomor WhatsApp',                   'type' => 'text',     'value' => ''],
            ['key' => 'store_address',      'group' => 'store', 'label' => 'Alamat',                           'type' => 'textarea', 'value' => 'Jakarta, Indonesia'],

            // ── FOOTER / SOSMED ───────────────────────────────────
            ['key' => 'social_facebook',    'group' => 'social', 'label' => 'URL Facebook',                   'type' => 'url',      'value' => '#'],
            ['key' => 'social_instagram',   'group' => 'social', 'label' => 'URL Instagram',                  'type' => 'url',      'value' => '#'],
            ['key' => 'social_twitter',     'group' => 'social', 'label' => 'URL Twitter / X',                'type' => 'url',      'value' => '#'],
            ['key' => 'social_youtube',     'group' => 'social', 'label' => 'URL YouTube',                    'type' => 'url',      'value' => '#'],
            ['key' => 'footer_copyright',   'group' => 'social', 'label' => 'Teks Copyright Footer',          'type' => 'text',     'value' => 'ATigaBookStore'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Site settings seeded successfully!');
    }
}
