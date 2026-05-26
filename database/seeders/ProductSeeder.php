<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductHighlight;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori ada
        $brands = ['Apple', 'Dell', 'ASUS', 'Lenovo', 'HP', 'Acer', 'MSI', 'Samsung', 'Razer', 'Microsoft'];
        $cats = [];
        foreach ($brands as $brand) {
            $cats[$brand] = Category::updateOrCreate(
                ['slug' => Str::slug($brand)],
                ['name' => $brand]
            );
        }

        $products = [

            // ══════════════ APPLE ══════════════
            [
                'category' => 'Apple',
                'name'     => 'Apple MacBook Pro 14" M3 Pro',
                'slug'     => 'apple-macbook-pro-14-m3-pro',
                'description' => 'MacBook Pro 14" dengan chip M3 Pro menghadirkan performa luar biasa untuk para profesional kreatif. Layar Liquid Retina XDR 3024×1964 dengan ProMotion 120Hz, baterai hingga 18 jam, dan sistem termal canggih membuatnya menjadi laptop terbaik di kelasnya.',
                'spec_title' => 'Performa Pro-Class Tanpa Kompromi',
                'spec_description' => 'M3 Pro chip 11-core CPU, 14-core GPU · 18GB Unified Memory · 512GB SSD · Liquid Retina XDR · HDMI 2.1 · SD Card · MagSafe 3',
                'price'  => 28999000,
                'stock'  => 15,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 18GB RAM', 'price' => 28999000],
                    ['type' => 'capacity', 'value' => '1TB | 18GB RAM',   'price' => 31999000],
                    ['type' => 'capacity', 'value' => '1TB | 36GB RAM',   'price' => 37999000],
                    ['type' => 'color', 'value' => 'Space Black',  'price' => null],
                    ['type' => 'color', 'value' => 'Silver',       'price' => null],
                ],
                'highlights' => [
                    ['label' => 'PROSESOR',  'title' => 'M3 Pro Chip',      'description' => '11-core CPU generasi terbaru Apple Silicon.'],
                    ['label' => 'LAYAR',     'title' => 'XDR 120Hz',        'description' => 'Liquid Retina XDR dengan ProMotion adaptive.'],
                    ['label' => 'BATERAI',   'title' => '18 Jam',           'description' => 'Baterai tahan seharian penuh tanpa perlu colokan.'],
                    ['label' => 'MEMORI',    'title' => '18GB Unified',     'description' => 'Unified Memory untuk multitasking mulus.'],
                ],
            ],
            [
                'category' => 'Apple',
                'name'     => 'Apple MacBook Pro 16" M3 Max',
                'slug'     => 'apple-macbook-pro-16-m3-max',
                'description' => 'Laptop paling bertenaga yang pernah dibuat Apple. MacBook Pro 16" dengan M3 Max chip dirancang untuk para kreator yang mengedit video 8K, render 3D, dan menjalankan ML model secara lokal. Performa GPU setara workstation namun dalam body yang tipis dan ringan.',
                'spec_title' => 'Workstation dalam Genggaman',
                'spec_description' => 'M3 Max chip 16-core CPU, 40-core GPU · 64GB Unified Memory · 1TB SSD · Liquid Retina XDR 16.2" · Thunderbolt 4 · Wi-Fi 6E',
                'price'  => 49999000,
                'stock'  => 8,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 48GB RAM',  'price' => 49999000],
                    ['type' => 'capacity', 'value' => '1TB | 64GB RAM',  'price' => 57999000],
                    ['type' => 'capacity', 'value' => '2TB | 128GB RAM', 'price' => 72999000],
                    ['type' => 'color', 'value' => 'Space Black', 'price' => null],
                    ['type' => 'color', 'value' => 'Silver',      'price' => null],
                ],
                'highlights' => [
                    ['label' => 'PROSESOR',  'title' => 'M3 Max 16-Core', 'description' => 'Chip terkencang dalam lini MacBook Pro.'],
                    ['label' => 'GPU',       'title' => '40-Core GPU',    'description' => 'Render 3D dan video 8K tanpa hambatan.'],
                    ['label' => 'LAYAR',     'title' => '16.2" XDR',      'description' => 'Layar terbesar dengan kecerahan 1600 nits.'],
                    ['label' => 'BATERAI',   'title' => '22 Jam',         'description' => 'Baterai terlama dalam sejarah Mac.'],
                ],
            ],
            [
                'category' => 'Apple',
                'name'     => 'Apple MacBook Air 15" M3',
                'slug'     => 'apple-macbook-air-15-m3',
                'description' => 'MacBook Air 15" tipis dan ringan dengan chip M3 yang revolusioner. Tanpa kipas, senyap total, namun tetap kencang untuk pekerjaan sehari-hari. Layar 15.3" Liquid Retina dengan 500 nits brightness dan 1 miliar warna.',
                'spec_title' => 'Ringan, Senyap, Bertenaga',
                'spec_description' => 'M3 chip 8-core CPU, 10-core GPU · 8GB Unified Memory · 256GB SSD · Liquid Retina 15.3" · MagSafe 3 · Thunderbolt/USB 4',
                'price'  => 19999000,
                'stock'  => 22,
                'variations' => [
                    ['type' => 'capacity', 'value' => '256GB | 8GB RAM',  'price' => 19999000],
                    ['type' => 'capacity', 'value' => '512GB | 8GB RAM',  'price' => 22999000],
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 25999000],
                    ['type' => 'color', 'value' => 'Midnight',    'price' => null],
                    ['type' => 'color', 'value' => 'Starlight',   'price' => null],
                    ['type' => 'color', 'value' => 'Space Gray',  'price' => null],
                    ['type' => 'color', 'value' => 'Silver',      'price' => null],
                ],
                'highlights' => [
                    ['label' => 'DESAIN',    'title' => 'Fanless Design', 'description' => 'Tanpa kipas, 100% senyap saat beroperasi.'],
                    ['label' => 'LAYAR',     'title' => '15.3" Retina',   'description' => 'Layar luas untuk produktivitas maksimal.'],
                    ['label' => 'BATERAI',   'title' => '18 Jam',         'description' => 'Seharian penuh tanpa perlu charger.'],
                    ['label' => 'BOBOT',     'title' => '1.51 kg',        'description' => 'Ringan untuk dibawa ke mana saja.'],
                ],
            ],

            // ══════════════ DELL ══════════════
            [
                'category' => 'Dell',
                'name'     => 'Dell XPS 15 OLED Touch',
                'slug'     => 'dell-xps-15-oled-touch',
                'description' => 'Dell XPS 15 hadir dengan layar OLED 3.5K sentuh yang memukau, didukung Intel Core i7-13700H dan RTX 4060. Desain premium CNC aluminum dengan keyboard full-size backlit. Pilihan terbaik untuk profesional kreatif yang butuh akurasi warna sempurna.',
                'spec_title' => 'OLED 3.5K Sentuh untuk Kreator',
                'spec_description' => 'Intel Core i7-13700H · RTX 4060 8GB · 32GB DDR5 · 1TB NVMe SSD · 15.6" OLED 3.5K Touch 60Hz · Thunderbolt 4 · Windows 11 Pro',
                'price'  => 29999000,
                'stock'  => 12,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 25999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 29999000],
                    ['type' => 'capacity', 'value' => '2TB | 64GB RAM',   'price' => 38999000],
                    ['type' => 'color', 'value' => 'Platinum Silver', 'price' => null],
                    ['type' => 'color', 'value' => 'Graphite',        'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',   'title' => 'OLED 3.5K Touch', 'description' => 'Panel OLED dengan 100% DCI-P3 dan sentuh.'],
                    ['label' => 'GPU',     'title' => 'RTX 4060 8GB',    'description' => 'Ray tracing dan DLSS untuk grafis memukau.'],
                    ['label' => 'DESAIN',  'title' => 'CNC Aluminum',    'description' => 'Bodi premium ringan hanya 1.86 kg.'],
                    ['label' => 'PORT',    'title' => 'Thunderbolt 4',   'description' => 'Transfer data 40Gbps dan DisplayPort.'],
                ],
            ],
            [
                'category' => 'Dell',
                'name'     => 'Dell XPS 13 Plus',
                'slug'     => 'dell-xps-13-plus',
                'description' => 'Dell XPS 13 Plus adalah laptop ultra-tipis terkompak dengan desain futuristik tanpa border. Keyboard seamless glass dengan haptic touchpad terbesar di kelas 13". Performa Intel Core i7 generasi ke-13 dalam bodi yang sangat ringkas.',
                'spec_title' => 'Ultra-Tipis Desain Masa Depan',
                'spec_description' => 'Intel Core i7-1360P · Iris Xe Graphics · 16GB LPDDR5 · 512GB SSD · 13.4" OLED 2.8K 60Hz · 2x Thunderbolt 4 · Windows 11',
                'price'  => 22999000,
                'stock'  => 18,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 22999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 26999000],
                    ['type' => 'color', 'value' => 'Platinum',        'price' => null],
                    ['type' => 'color', 'value' => 'Graphite',        'price' => null],
                ],
                'highlights' => [
                    ['label' => 'DESAIN',   'title' => 'Borderless XPS',  'description' => 'Layar tanpa bezel untuk imersi penuh.'],
                    ['label' => 'KEYBOARD', 'title' => 'Haptic Glass',    'description' => 'Touchpad terbesar di XPS 13 dengan haptic.'],
                    ['label' => 'PROSESOR', 'title' => 'i7-1360P',        'description' => '12-core hybrid architecture Intel.'],
                    ['label' => 'BOBOT',    'title' => '1.27 kg',         'description' => 'Salah satu laptop 13" teringan.'],
                ],
            ],
            [
                'category' => 'Dell',
                'name'     => 'Dell Alienware m18 R2',
                'slug'     => 'dell-alienware-m18-r2',
                'description' => 'Alienware m18 R2 adalah monster gaming laptop dengan layar 18" QHD 240Hz. Ditenagai RTX 4090 dan Intel i9-14900HX, laptop ini adalah mesin gaming paling bertenaga yang pernah ada. Sistem pendingin dual-fan eksklusif Alienware menjaga suhu tetap optimal.',
                'spec_title' => 'Monster Gaming 18 Inci',
                'spec_description' => 'Intel Core i9-14900HX · RTX 4090 16GB · 64GB DDR5 · 2TB NVMe SSD · 18" QHD+ 240Hz · Cherry MX Ultra Low Profile · Windows 11',
                'price'  => 69999000,
                'stock'  => 5,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',  'price' => 55999000],
                    ['type' => 'capacity', 'value' => '2TB | 64GB RAM',  'price' => 69999000],
                    ['type' => 'color', 'value' => 'Dark Metallic Moon', 'price' => null],
                    ['type' => 'color', 'value' => 'Lunar Light',        'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',      'title' => 'RTX 4090 16GB',   'description' => 'GPU mobile terkuat untuk gaming 4K.'],
                    ['label' => 'LAYAR',    'title' => '18" QHD 240Hz',   'description' => 'Layar gaming besar dengan refresh rate tinggi.'],
                    ['label' => 'THERMAL',  'title' => 'Dual Fan',         'description' => 'Pendingin ganda Alienware Cryo-Tech.'],
                    ['label' => 'MEMORI',   'title' => '64GB DDR5',        'description' => 'RAM besar untuk gaming dan streaming sekaligus.'],
                ],
            ],

            // ══════════════ ASUS ══════════════
            [
                'category' => 'ASUS',
                'name'     => 'ASUS ROG Strix G16 RTX 4070',
                'slug'     => 'asus-rog-strix-g16-rtx-4070',
                'description' => 'ASUS ROG Strix G16 hadir dengan RTX 4070 dan layar 16" QHD+ 240Hz yang memukau. Sistem pendingin Tri-Fan dengan heatsink besar memastikan performa konsisten saat gaming marathon. Keyboard ROG per-key RGB dengan NKRO.',
                'spec_title' => 'Dominasi Gaming 240Hz',
                'spec_description' => 'Intel Core i9-13980HX · RTX 4070 8GB · 32GB DDR5 · 2TB NVMe SSD · 16" QHD+ 240Hz IPS · Wi-Fi 6E · Windows 11',
                'price'  => 32999000,
                'stock'  => 10,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',  'price' => 27999000],
                    ['type' => 'capacity', 'value' => '2TB | 32GB RAM',  'price' => 32999000],
                    ['type' => 'color', 'value' => 'Eclipse Gray',   'price' => null],
                    ['type' => 'color', 'value' => 'Volt Green',     'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',     'title' => 'RTX 4070 8GB',  'description' => 'DLSS 3 dan ray tracing generasi terbaru.'],
                    ['label' => 'LAYAR',   'title' => 'QHD+ 240Hz',    'description' => 'Resolusi tinggi dengan refresh rate ekstrem.'],
                    ['label' => 'THERMAL', 'title' => 'Tri-Fan Tech',  'description' => 'Tiga kipas independen untuk suhu optimal.'],
                    ['label' => 'RGB',     'title' => 'Aura Sync',     'description' => 'Per-key RGB dengan 16.8 juta warna.'],
                ],
            ],
            [
                'category' => 'ASUS',
                'name'     => 'ASUS ZenBook Pro 16X OLED',
                'slug'     => 'asus-zenbook-pro-16x-oled',
                'description' => 'ZenBook Pro 16X OLED menggabungkan kinerja workstation dan estetika premium. Layar OLED 3.2K 120Hz dengan PANTONE Validated dan fitur unik ASUS Dial untuk kontrol kreatif. Didukung RTX 4060 dan AMD Ryzen 9 untuk performa seimbang.',
                'spec_title' => 'Kreativitas Tanpa Batas',
                'spec_description' => 'AMD Ryzen 9 7945HX · RTX 4060 8GB · 32GB LPDDR5 · 1TB SSD · 16" OLED 3.2K 120Hz · ASUS Dial · Windows 11 Pro',
                'price'  => 27999000,
                'stock'  => 14,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM', 'price' => 23999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM', 'price' => 27999000],
                    ['type' => 'color', 'value' => 'Tech Black', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',    'title' => 'OLED 3.2K 120Hz', 'description' => 'PANTONE Validated, 100% DCI-P3.'],
                    ['label' => 'FITUR',    'title' => 'ASUS Dial',        'description' => 'Dial fisik untuk kontrol kreatif intuitif.'],
                    ['label' => 'GPU',      'title' => 'RTX 4060 8GB',    'description' => 'Render dan AI acceleration terdepan.'],
                    ['label' => 'PROSESOR', 'title' => 'Ryzen 9 7945HX',  'description' => '16-core untuk multitasking berat.'],
                ],
            ],
            [
                'category' => 'ASUS',
                'name'     => 'ASUS VivoBook 16X OLED',
                'slug'     => 'asus-vivobook-16x-oled',
                'description' => 'VivoBook 16X OLED menghadirkan layar OLED 16" 2.8K yang indah dengan harga terjangkau. Cocok untuk mahasiswa dan profesional muda yang menginginkan kualitas layar premium tanpa merusak kantong.',
                'spec_title' => 'OLED 16" untuk Semua Kalangan',
                'spec_description' => 'AMD Ryzen 7 7745HX · RTX 4060 · 16GB DDR5 · 512GB SSD · 16" OLED 2.8K 120Hz · Windows 11 Home',
                'price'  => 16999000,
                'stock'  => 25,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 16999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 18999000],
                    ['type' => 'color', 'value' => 'Midnight Black', 'price' => null],
                    ['type' => 'color', 'value' => 'Cool Silver',    'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',    'title' => 'OLED 2.8K',     'description' => '120Hz dengan 100% DCI-P3 color gamut.'],
                    ['label' => 'HARGA',    'title' => 'Best Value',     'description' => 'OLED terjangkau tanpa kompromi kualitas.'],
                    ['label' => 'PROSESOR', 'title' => 'Ryzen 7 7745HX', 'description' => '8-core untuk produktivitas tinggi.'],
                    ['label' => 'BERAT',    'title' => '1.88 kg',        'description' => 'Ringan untuk laptop 16 inci.'],
                ],
            ],

            // ══════════════ LENOVO ══════════════
            [
                'category' => 'Lenovo',
                'name'     => 'Lenovo ThinkPad X1 Carbon Gen 12',
                'slug'     => 'lenovo-thinkpad-x1-carbon-gen-12',
                'description' => 'ThinkPad X1 Carbon Gen 12 adalah laptop bisnis legendaris yang terus berevolusi. Sertifikasi MIL-SPEC 810H untuk ketahanan ekstrem, keyboard TrackPoint ikonik, dan baterai hingga 15 jam. Pilihan nomor satu para eksekutif dan profesional bisnis.',
                'spec_title' => 'Business Class Terdepan',
                'spec_description' => 'Intel Core Ultra 7 155U · Intel Arc Graphics · 16GB LPDDR5 · 512GB SSD · 14" IPS 2.8K OLED · MIL-SPEC 810H · Windows 11 Pro',
                'price'  => 26999000,
                'stock'  => 20,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 26999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 31999000],
                    ['type' => 'color', 'value' => 'Black', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'DAYA TAHAN', 'title' => 'MIL-SPEC 810H', 'description' => 'Lulus 12 uji ketahanan militer.'],
                    ['label' => 'KEYBOARD',   'title' => 'TrackPoint',     'description' => 'Keyboard bisnis terbaik di kelasnya.'],
                    ['label' => 'BATERAI',    'title' => '15 Jam',         'description' => 'Bekerja seharian tanpa charger.'],
                    ['label' => 'BOBOT',      'title' => '1.12 kg',        'description' => 'ThinkPad teringan sepanjang sejarah.'],
                ],
            ],
            [
                'category' => 'Lenovo',
                'name'     => 'Lenovo Legion 7i Gen 9',
                'slug'     => 'lenovo-legion-7i-gen-9',
                'description' => 'Legion 7i Gen 9 adalah gaming laptop premium dengan desain elegan yang tidak terlihat seperti laptop gaming biasa. RTX 4070 Ti Super dengan TGP 175W, layar Mini LED 2560×1600 165Hz, dan sistem pendingin Legion Cold Front 5.0.',
                'spec_title' => 'Gaming Premium Elegan',
                'spec_description' => 'Intel Core i9-14900HX · RTX 4070 Ti Super 12GB · 32GB DDR5 · 1TB SSD · 16" Mini LED 2K 165Hz · Legion AI Chip · Windows 11',
                'price'  => 38999000,
                'stock'  => 8,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',  'price' => 38999000],
                    ['type' => 'capacity', 'value' => '2TB | 64GB RAM',  'price' => 46999000],
                    ['type' => 'color', 'value' => 'Luna Grey',      'price' => null],
                    ['type' => 'color', 'value' => 'Cosmic Black',   'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',     'title' => 'RTX 4070 Ti Super', 'description' => '12GB VRAM dengan TGP 175W penuh.'],
                    ['label' => 'LAYAR',   'title' => 'Mini LED 165Hz',    'description' => '2560×1600 dengan local dimming 1152 zone.'],
                    ['label' => 'THERMAL', 'title' => 'Cold Front 5.0',   'description' => 'Pendingin cerdas berbasis AI Lenovo.'],
                    ['label' => 'DESAIN',  'title' => 'Premium Metal',    'description' => 'Bodi magnesium alloy yang tipis dan kokoh.'],
                ],
            ],
            [
                'category' => 'Lenovo',
                'name'     => 'Lenovo Yoga 9i Gen 9 2-in-1',
                'slug'     => 'lenovo-yoga-9i-gen-9-2in1',
                'description' => 'Yoga 9i Gen 9 adalah laptop 2-in-1 premium dengan engsel torsion bar unik dan stylus aktif terintegrasi. Layar OLED 2.8K sentuh dengan 100% P3. Rotasi 360 derajat untuk mode laptop, tablet, stand, dan tent.',
                'spec_title' => '360° Premium 2-in-1',
                'spec_description' => 'Intel Core Ultra 7 155H · Intel Arc Graphics · 16GB LPDDR5 · 512GB SSD · 14" OLED 2.8K Touch · Active Pen · Windows 11 Home',
                'price'  => 24999000,
                'stock'  => 17,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 24999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 27999000],
                    ['type' => 'color', 'value' => 'Oatmeal',        'price' => null],
                    ['type' => 'color', 'value' => 'Storm Grey',     'price' => null],
                ],
                'highlights' => [
                    ['label' => 'FORM FACTOR', 'title' => '360° 2-in-1',   'description' => 'Empat mode penggunaan fleksibel.'],
                    ['label' => 'LAYAR',       'title' => 'OLED Touch',     'description' => 'OLED 2.8K sentuh dengan Dolby Vision.'],
                    ['label' => 'STYLUS',      'title' => 'Active Pen',     'description' => 'Stylus tersimpan di bodi tanpa perlu bawa sendiri.'],
                    ['label' => 'AUDIO',       'title' => 'Bowers & Wilkins','description' => 'Speaker premium 4 driver tuning spesial.'],
                ],
            ],

            // ══════════════ HP ══════════════
            [
                'category' => 'HP',
                'name'     => 'HP Spectre x360 14" OLED',
                'slug'     => 'hp-spectre-x360-14-oled',
                'description' => 'HP Spectre x360 adalah simbol kemewahan dan fleksibilitas. Desain gem-cut premium dengan bezel tipis, layar OLED 2.8K sentuh, dan kemampuan 360 derajat. Termasuk HP Tilt Pen generasi terbaru. Laptop paling premium dari HP untuk eksekutif modern.',
                'spec_title' => 'Kemewahan dalam Genggaman',
                'spec_description' => 'Intel Core Ultra 7 155H · Intel Arc Graphics · 16GB LPDDR5 · 1TB SSD · 14" OLED 2.8K Touch · HP Tilt Pen · Windows 11 Pro',
                'price'  => 23999000,
                'stock'  => 16,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 20999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 23999000],
                    ['type' => 'capacity', 'value' => '2TB | 32GB RAM',   'price' => 28999000],
                    ['type' => 'color', 'value' => 'Nightfall Black', 'price' => null],
                    ['type' => 'color', 'value' => 'Natural Silver',  'price' => null],
                    ['type' => 'color', 'value' => 'Slate Blue',      'price' => null],
                ],
                'highlights' => [
                    ['label' => 'DESAIN',   'title' => 'Gem-Cut Premium', 'description' => 'Desain berlian eksklusif HP Spectre.'],
                    ['label' => 'LAYAR',    'title' => 'OLED 2.8K Touch', 'description' => 'Sentuh dengan 100% DCI-P3 color.'],
                    ['label' => 'STYLUS',   'title' => 'HP Tilt Pen',    'description' => 'Pen sensitif 4096 level tekanan.'],
                    ['label' => 'BATERAI',  'title' => '17 Jam',         'description' => 'Baterai besar untuk produktivitas sepanjang hari.'],
                ],
            ],
            [
                'category' => 'HP',
                'name'     => 'HP OMEN 16 RTX 4060',
                'slug'     => 'hp-omen-16-rtx-4060',
                'description' => 'HP OMEN 16 menghadirkan pengalaman gaming premium dengan RTX 4060 dan AMD Ryzen 7. Layar 165Hz QHD untuk tampilan crisp saat gaming. Sistem pendingin OMEN Tempest Cooling dengan 5 heat pipe untuk suhu terkontrol.',
                'spec_title' => 'Gaming Bertenaga Harga Tepat',
                'spec_description' => 'AMD Ryzen 7 7745HX · RTX 4060 8GB · 16GB DDR5 · 512GB SSD · 16.1" QHD 165Hz · OMEN Tempest Cooling · Windows 11 Home',
                'price'  => 19999000,
                'stock'  => 20,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 19999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 24999000],
                    ['type' => 'color', 'value' => 'Shadow Black', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',     'title' => 'RTX 4060 8GB',   'description' => 'Gaming 1440p mulus tanpa hambatan.'],
                    ['label' => 'LAYAR',   'title' => 'QHD 165Hz',      'description' => 'Resolusi tinggi untuk detail visual.'],
                    ['label' => 'THERMAL', 'title' => 'Tempest Cooling', 'description' => '5 heat pipe & 2 kipas besar.'],
                    ['label' => 'AUDIO',   'title' => 'Bang & Olufsen', 'description' => 'Suara sinema di dalam laptop.'],
                ],
            ],
            [
                'category' => 'HP',
                'name'     => 'HP EliteBook 1040 G11',
                'slug'     => 'hp-elitebook-1040-g11',
                'description' => 'HP EliteBook 1040 G11 adalah laptop bisnis ultra-tipis berkelas enterprise dengan keamanan HP Wolf Security bawaan. Sertifikasi EPEAT Gold dan Energy Star. Layar Sure View Reflect untuk privasi di tempat publik.',
                'spec_title' => 'Enterprise Security Terdepan',
                'spec_description' => 'Intel Core Ultra 7 164U · Intel Arc Graphics · 32GB LPDDR5 · 1TB SSD · 14" IPS 2.8K · HP Wolf Security · Windows 11 Pro',
                'price'  => 29999000,
                'stock'  => 11,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 25999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 29999000],
                    ['type' => 'color', 'value' => 'Silver', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'KEAMANAN', 'title' => 'HP Wolf Security', 'description' => 'Keamanan enterprise hardware & software.'],
                    ['label' => 'PRIVASI',  'title' => 'Sure View',        'description' => 'Layar anti-intip untuk privasi publik.'],
                    ['label' => 'SERTIF',   'title' => 'EPEAT Gold',       'description' => 'Ramah lingkungan berkelas tertinggi.'],
                    ['label' => 'BATERAI',  'title' => '18 Jam',           'description' => 'Tahan lama untuk perjalanan bisnis.'],
                ],
            ],

            // ══════════════ ACER ══════════════
            [
                'category' => 'Acer',
                'name'     => 'Acer Predator Helios Neo 16',
                'slug'     => 'acer-predator-helios-neo-16',
                'description' => 'Predator Helios Neo 16 menghadirkan nilai terbaik dalam gaming laptop berperforma tinggi. RTX 4070 dengan AeroBlade 3D Fan 5th Gen dan 5 heat pipe. Layar 2K 165Hz dengan respons time 3ms untuk gaming kompetitif.',
                'spec_title' => 'Predator Tangguh Harga Terjangkau',
                'spec_description' => 'Intel Core i7-13700HX · RTX 4070 8GB · 16GB DDR5 · 1TB SSD · 16" WQXGA 165Hz IPS · AeroBlade 3D · Windows 11 Home',
                'price'  => 21999000,
                'stock'  => 18,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 18999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 21999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 24999000],
                    ['type' => 'color', 'value' => 'Abyssal Black', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',     'title' => 'RTX 4070 8GB',   'description' => 'Gaming 2K dan ray tracing lancar.'],
                    ['label' => 'THERMAL', 'title' => 'AeroBlade 3D',   'description' => 'Kipas 89-blade 5th gen dengan 5 heat pipe.'],
                    ['label' => 'LAYAR',   'title' => 'WQXGA 165Hz',    'description' => '2560×1600 IPS dengan 3ms respons time.'],
                    ['label' => 'NILAI',   'title' => 'Best Value RTX', 'description' => 'RTX 4070 dengan harga paling kompetitif.'],
                ],
            ],
            [
                'category' => 'Acer',
                'name'     => 'Acer Swift X 16 OLED',
                'slug'     => 'acer-swift-x-16-oled',
                'description' => 'Acer Swift X 16 menggabungkan desain tipis ringan dengan RTX 4070 untuk performa kreatif. Layar OLED 16" 3.2K 120Hz dengan 100% DCI-P3 dan PANTONE Validated. Bobot hanya 1.8kg untuk laptop bertenaga GPU diskret.',
                'spec_title' => 'Tipis, Ringan, Bertenaga Penuh',
                'spec_description' => 'Intel Core i7-13700H · RTX 4070 8GB · 16GB DDR5 · 1TB SSD · 16" OLED 3.2K 120Hz · 1.8kg · Windows 11 Home',
                'price'  => 18999000,
                'stock'  => 22,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 16999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 18999000],
                    ['type' => 'color', 'value' => 'Steam Blue', 'price' => null],
                    ['type' => 'color', 'value' => 'Stellar White', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',  'title' => 'OLED 3.2K',     'description' => 'PANTONE Validated 100% DCI-P3.'],
                    ['label' => 'BOBOT',  'title' => '1.8 kg',        'description' => 'Ringan untuk laptop GPU diskret 16".'],
                    ['label' => 'GPU',    'title' => 'RTX 4070',      'description' => 'Performa kreatif dan gaming kelas atas.'],
                    ['label' => 'BATERAI','title' => '76Wh',          'description' => 'Baterai besar untuk portabilitas.'],
                ],
            ],
            [
                'category' => 'Acer',
                'name'     => 'Acer Aspire 5 Slim',
                'slug'     => 'acer-aspire-5-slim',
                'description' => 'Acer Aspire 5 Slim adalah pilihan terbaik bagi mahasiswa dan profesional yang membutuhkan laptop handal dengan harga ramah kantong. Desain slim dengan layar IPS Full HD, prosesor AMD Ryzen 5, dan keyboard backlit.',
                'spec_title' => 'Andalan Sehari-hari yang Terjangkau',
                'spec_description' => 'AMD Ryzen 5 7530U · AMD Radeon Graphics · 8GB DDR4 · 512GB SSD · 15.6" FHD IPS 60Hz · USB-C · Windows 11 Home',
                'price'  => 8999000,
                'stock'  => 40,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 8GB RAM',  'price' => 8999000],
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 10999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 12999000],
                    ['type' => 'color', 'value' => 'Steel Gray',   'price' => null],
                    ['type' => 'color', 'value' => 'Pure Silver',  'price' => null],
                ],
                'highlights' => [
                    ['label' => 'HARGA',    'title' => 'Budget Friendly', 'description' => 'Nilai terbaik untuk pelajar dan mahasiswa.'],
                    ['label' => 'PROSESOR', 'title' => 'Ryzen 5 7530U',  'description' => '6-core untuk produktivitas harian.'],
                    ['label' => 'LAYAR',    'title' => 'FHD IPS',        'description' => 'Full HD jernih untuk kerja dan hiburan.'],
                    ['label' => 'BATERAI',  'title' => '11.5 Jam',       'description' => 'Seharian penuh tanpa charger.'],
                ],
            ],

            // ══════════════ MSI ══════════════
            [
                'category' => 'MSI',
                'name'     => 'MSI Raider GE78HX RTX 4090',
                'slug'     => 'msi-raider-ge78hx-rtx-4090',
                'description' => 'MSI Raider GE78HX adalah raja di antara gaming laptop. RTX 4090 dengan 175W TGP penuh, layar 17" Mini LED QHD+ 240Hz, dan desain futuristik dengan per-key RGB SteelSeries keyboard. Tidak ada kompromi dalam performa gaming.',
                'spec_title' => 'Raja Gaming Laptop 2024',
                'spec_description' => 'Intel Core i9-14900HX · RTX 4090 16GB 175W · 64GB DDR5 · 4TB NVMe · 17" Mini LED QHD+ 240Hz · Thunderbolt 5 · Windows 11',
                'price'  => 74999000,
                'stock'  => 4,
                'variations' => [
                    ['type' => 'capacity', 'value' => '2TB | 32GB RAM',  'price' => 59999000],
                    ['type' => 'capacity', 'value' => '4TB | 64GB RAM',  'price' => 74999000],
                    ['type' => 'color', 'value' => 'Core Black', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'GPU',      'title' => 'RTX 4090 175W',   'description' => 'Full TGP tanpa throttle di chassis gaming.'],
                    ['label' => 'LAYAR',    'title' => 'Mini LED 240Hz',  'description' => 'QHD+ 240Hz dengan local dimming.'],
                    ['label' => 'PORT',     'title' => 'Thunderbolt 5',   'description' => 'Transfer data 120Gbps — generasi terbaru.'],
                    ['label' => 'KEYBOARD', 'title' => 'SteelSeries',     'description' => 'Per-key RGB dengan polling rate 4000Hz.'],
                ],
            ],
            [
                'category' => 'MSI',
                'name'     => 'MSI Prestige 16 AI Studio',
                'slug'     => 'msi-prestige-16-ai-studio',
                'description' => 'MSI Prestige 16 AI Studio dirancang untuk profesional kreatif yang membutuhkan performa AI dan grafis dalam desain premium. Layar OLED 4K 120Hz dengan True Pixel display dan kecerahan 600 nits. Sertifikasi PANTONE Validated.',
                'spec_title' => 'AI-Powered Studio Profesional',
                'spec_description' => 'Intel Core Ultra 9 185H · RTX 4060 8GB · 32GB LPDDR5 · 1TB SSD · 16" OLED 4K 120Hz · AI Boost · Windows 11 Pro',
                'price'  => 31999000,
                'stock'  => 9,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',  'price' => 26999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',  'price' => 31999000],
                    ['type' => 'color', 'value' => 'Prestige White', 'price' => null],
                    ['type' => 'color', 'value' => 'Deep Black',     'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',    'title' => 'OLED 4K 120Hz',  'description' => '4K OLED tertipis di kelas kreator.'],
                    ['label' => 'AI',       'title' => 'AI Boost',        'description' => 'NPU terintegrasi untuk tugas AI.'],
                    ['label' => 'SERTIF',   'title' => 'PANTONE Valid',   'description' => 'Warna akurat untuk desainer profesional.'],
                    ['label' => 'BOBOT',    'title' => '1.69 kg',         'description' => 'Ringan untuk laptop kreatif 16".'],
                ],
            ],

            // ══════════════ RAZER ══════════════
            [
                'category' => 'Razer',
                'name'     => 'Razer Blade 16 RTX 4090',
                'slug'     => 'razer-blade-16-rtx-4090',
                'description' => 'Razer Blade 16 adalah gaming laptop paling premium dengan desain unibody CNC aluminum. Layar Mini LED 4K/240Hz dual-mode unik yang bisa berganti resolusi. RTX 4090 dalam bodi yang sangat tipis untuk sebuah gaming laptop kelas atas.',
                'spec_title' => 'The World\'s First Dual-Mode Display',
                'spec_description' => 'Intel Core i9-14900HX · RTX 4090 16GB · 32GB DDR5 · 2TB SSD · 16" Mini LED 4K UHD/FHD 240Hz · Thunderbolt 5 · Windows 11',
                'price'  => 79999000,
                'stock'  => 3,
                'variations' => [
                    ['type' => 'capacity', 'value' => '2TB | 32GB RAM',  'price' => 79999000],
                    ['type' => 'color', 'value' => 'Mercury White', 'price' => null],
                    ['type' => 'color', 'value' => 'Onyx Black',   'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',    'title' => 'Dual-Mode 4K',   'description' => '4K 60Hz atau FHD 240Hz, kamu pilih.'],
                    ['label' => 'GPU',      'title' => 'RTX 4090',       'description' => 'GPU mobile terkuat dalam bodi tipis.'],
                    ['label' => 'DESAIN',   'title' => 'CNC Unibody',    'description' => 'Bodi aluminum presisi mesin CNC.'],
                    ['label' => 'PORT',     'title' => 'Thunderbolt 5',  'description' => 'Koneksi terkencang generasi terbaru.'],
                ],
            ],
            [
                'category' => 'Razer',
                'name'     => 'Razer Blade 14 RTX 4070',
                'slug'     => 'razer-blade-14-rtx-4070',
                'description' => 'Razer Blade 14 adalah gaming laptop 14" terkencang di dunia. AMD Ryzen 9 8945HS dan RTX 4070 dalam bodi yang hanya 1.65kg. Layar QHD+ 165Hz dengan 100% DCI-P3. Pilihan utama gamer mobile yang tidak mau kompromi performa.',
                'spec_title' => 'Gaming 14" Terkencang di Dunia',
                'spec_description' => 'AMD Ryzen 9 8945HS · RTX 4070 8GB · 32GB DDR5 · 1TB SSD · 14" QHD+ 165Hz 100% DCI-P3 · 1.65kg · Windows 11',
                'price'  => 39999000,
                'stock'  => 7,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',  'price' => 33999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',  'price' => 39999000],
                    ['type' => 'color', 'value' => 'Onyx Black',   'price' => null],
                    ['type' => 'color', 'value' => 'Mercury White', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'KOMPAK',  'title' => '14" 1.65kg',   'description' => 'Gaming laptop kompak teringan dengan RTX 4070.'],
                    ['label' => 'GPU',     'title' => 'RTX 4070',     'description' => 'Gaming 1440p mulus di bodi mungil.'],
                    ['label' => 'LAYAR',   'title' => 'QHD+ 165Hz',  'description' => '100% DCI-P3 untuk warna vivid.'],
                    ['label' => 'DESAIN',  'title' => 'CNC Aluminum', 'description' => 'Build quality premium khas Razer.'],
                ],
            ],

            // ══════════════ SAMSUNG ══════════════
            [
                'category' => 'Samsung',
                'name'     => 'Samsung Galaxy Book4 Pro 360',
                'slug'     => 'samsung-galaxy-book4-pro-360',
                'description' => 'Galaxy Book4 Pro 360 adalah laptop Windows premium dengan layar AMOLED 2K Dynamic yang menakjubkan dan S Pen terintegrasi. Terintegrasi sempurna dengan ekosistem Samsung Galaxy. Desain tipis 11.4mm dengan bodi ringan dari aluminum.',
                'spec_title' => 'Galaxy Ecosystem Premium 2-in-1',
                'spec_description' => 'Intel Core Ultra 7 155H · Intel Arc Graphics · 16GB LPDDR5 · 512GB SSD · 14" AMOLED 2K Dynamic Touch · S Pen · Windows 11',
                'price'  => 22999000,
                'stock'  => 14,
                'variations' => [
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 22999000],
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',   'price' => 25999000],
                    ['type' => 'color', 'value' => 'Moonstone Gray', 'price' => null],
                    ['type' => 'color', 'value' => 'Sapphire Blue',  'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',    'title' => 'AMOLED 2K Dynamic', 'description' => 'Dynamic refresh 1-120Hz adaptif.'],
                    ['label' => 'STYLUS',   'title' => 'S Pen Built-in',    'description' => 'S Pen tersimpan di dalam bodi.'],
                    ['label' => 'EKOSISTEM','title' => 'Galaxy Linked',     'description' => 'Terhubung mulus dengan Galaxy Phone & Tab.'],
                    ['label' => 'TIPIS',    'title' => '11.4mm',            'description' => 'Salah satu 2-in-1 paling tipis.'],
                ],
            ],
            [
                'category' => 'Samsung',
                'name'     => 'Samsung Galaxy Book4 Ultra',
                'slug'     => 'samsung-galaxy-book4-ultra',
                'description' => 'Galaxy Book4 Ultra adalah laptop Samsung terkencang dengan RTX 4070 dan Intel Core Ultra 9. Layar AMOLED 3K 120Hz dengan 10-bit color depth. Dirancang untuk kreator konten dan profesional yang butuh performa maksimal dalam desain elegan.',
                'spec_title' => 'Samsung Terkencang untuk Kreator',
                'spec_description' => 'Intel Core Ultra 9 185H · RTX 4070 8GB · 32GB LPDDR5 · 1TB SSD · 16" AMOLED 3K 120Hz · Galaxy AI · Windows 11 Pro',
                'price'  => 33999000,
                'stock'  => 9,
                'variations' => [
                    ['type' => 'capacity', 'value' => '1TB | 16GB RAM',  'price' => 28999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',  'price' => 33999000],
                    ['type' => 'color', 'value' => 'Moonstone Gray', 'price' => null],
                ],
                'highlights' => [
                    ['label' => 'LAYAR',  'title' => 'AMOLED 3K 120Hz', 'description' => '3K 10-bit color untuk warna sempurna.'],
                    ['label' => 'GPU',    'title' => 'RTX 4070 8GB',    'description' => 'Kreasi 3D dan gaming premium.'],
                    ['label' => 'AI',     'title' => 'Galaxy AI',       'description' => 'Fitur AI terpadu dengan Galaxy ekosistem.'],
                    ['label' => 'DESAIN', 'title' => 'Anodized Slim',   'description' => 'Bodi aluminum anodized premium tipis.'],
                ],
            ],

            // ══════════════ MICROSOFT ══════════════
            [
                'category' => 'Microsoft',
                'name'     => 'Microsoft Surface Pro 10 Intel',
                'slug'     => 'microsoft-surface-pro-10-intel',
                'description' => 'Surface Pro 10 adalah tablet Windows terbaik yang bisa menjadi laptop penuh. Layar Pixelsense Flow 13" dengan 120Hz dan Dolby Vision IQ. Terintegrasi dengan Surface Pen dan Surface Keyboard untuk produktivitas maksimal. Cocok untuk profesional mobile.',
                'spec_title' => 'Tablet yang Lebih Bertenaga dari Laptop',
                'spec_description' => 'Intel Core Ultra 7 165U · Intel Arc Graphics · 16GB LPDDR5 · 512GB SSD · 13" Pixelsense 2880×1920 120Hz · Windows 11 Pro',
                'price'  => 24999000,
                'stock'  => 13,
                'variations' => [
                    ['type' => 'capacity', 'value' => '256GB | 16GB RAM', 'price' => 20999000],
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 24999000],
                    ['type' => 'capacity', 'value' => '1TB | 32GB RAM',   'price' => 30999000],
                    ['type' => 'color', 'value' => 'Platinum',  'price' => null],
                    ['type' => 'color', 'value' => 'Forest',    'price' => null],
                    ['type' => 'color', 'value' => 'Sapphire',  'price' => null],
                ],
                'highlights' => [
                    ['label' => 'FORM',     'title' => 'Tablet + Laptop',  'description' => 'Fleksibel berganti mode kapanpun.'],
                    ['label' => 'LAYAR',    'title' => 'Pixelsense 120Hz', 'description' => 'Dolby Vision IQ untuk HDR otomatis.'],
                    ['label' => 'KONEKSI',  'title' => 'Wi-Fi 6E + 5G',   'description' => 'Konektivitas terluas di kelasnya.'],
                    ['label' => 'KAMERA',   'title' => '1080p Studio',     'description' => 'Kamera AI untuk video conference.'],
                ],
            ],
            [
                'category' => 'Microsoft',
                'name'     => 'Microsoft Surface Laptop 6',
                'slug'     => 'microsoft-surface-laptop-6',
                'description' => 'Surface Laptop 6 hadir dengan Copilot+ AI terdepan berbasis Snapdragon X Elite. Performa 45% lebih cepat dari generasi sebelumnya dengan baterai hingga 22 jam. Layar PixelSense 13.8" IPS 120Hz dengan Dolby Vision.',
                'spec_title' => 'Copilot+ PC Terdepan',
                'spec_description' => 'Snapdragon X Elite X1E-80-100 · Qualcomm Adreno GPU · 16GB LPDDR5 · 512GB SSD · 13.8" IPS 2256×1504 120Hz · Windows 11 Copilot+',
                'price'  => 19999000,
                'stock'  => 16,
                'variations' => [
                    ['type' => 'capacity', 'value' => '256GB | 16GB RAM', 'price' => 17999000],
                    ['type' => 'capacity', 'value' => '512GB | 16GB RAM', 'price' => 19999000],
                    ['type' => 'capacity', 'value' => '1TB | 64GB RAM',   'price' => 26999000],
                    ['type' => 'color', 'value' => 'Platinum',      'price' => null],
                    ['type' => 'color', 'value' => 'Sapphire',      'price' => null],
                    ['type' => 'color', 'value' => 'Dune',          'price' => null],
                ],
                'highlights' => [
                    ['label' => 'AI',      'title' => 'Copilot+ PC',    'description' => 'AI terpadu di setiap aspek Windows.'],
                    ['label' => 'BATERAI', 'title' => '22 Jam',         'description' => 'Rekor baterai terlama Surface Laptop.'],
                    ['label' => 'CHIP',    'title' => 'Snapdragon X',   'description' => 'Chip ARM tercepat untuk Windows.'],
                    ['label' => 'TIPIS',   'title' => '11.5mm',         'description' => 'Surface Laptop tertipis yang pernah ada.'],
                ],
            ],
        ];

        foreach ($products as $data) {
            $category = $cats[$data['category']];

            $product = Product::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id'      => $category->id,
                    'name'             => $data['name'],
                    'description'      => $data['description'],
                    'spec_title'       => $data['spec_title'],
                    'spec_description' => $data['spec_description'],
                    'price'            => $data['price'],
                    'stock'            => $data['stock'],
                    'image'            => null,
                ]
            );

            // Hapus variasi & highlight lama lalu buat baru
            $product->variations()->delete();
            $product->highlights()->delete();

            foreach ($data['variations'] as $v) {
                ProductVariation::create([
                    'product_id' => $product->id,
                    'type'       => $v['type'],
                    'value'      => $v['value'],
                    'price'      => $v['price'],
                ]);
            }

            foreach ($data['highlights'] as $h) {
                ProductHighlight::create([
                    'product_id'  => $product->id,
                    'label'       => $h['label'],
                    'title'       => $h['title'],
                    'description' => $h['description'],
                ]);
            }
        }

        $this->command->info('✅ ' . count($products) . ' produk berhasil di-seed!');
    }
}
