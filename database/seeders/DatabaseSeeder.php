<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'service_name' => 'Paket Home 50',
                'speed' => 50,
                'price' => 250000,
                'description' => 'Cocok untuk browsing ringan, streaming video HD, dan gaming casual. Ideal untuk keluarga kecil dengan 3-4 perangkat.',
                'status' => 'aktif'
            ],
            [
                'service_name' => 'Paket Home 75',
                'speed' => 75,
                'price' => 350000,
                'description' => 'Perfect untuk keluarga menengah. Streaming 4K, video conference, dan gaming online tanpa lag. Support 5-6 perangkat sekaligus.',
                'status' => 'aktif'
            ],
            [
                'service_name' => 'Paket Home 100',
                'speed' => 100,
                'price' => 450000,
                'description' => 'Koneksi super cepat untuk keluarga besar atau WFH. Download file besar, streaming 4K multiple device, gaming kompetitif. Support 7-10 perangkat.',
                'status' => 'aktif'
            ],
            [
                'service_name' => 'Paket Business 200',
                'speed' => 200,
                'price' => 850000,
                'description' => 'Solusi terbaik untuk kantor atau bisnis online. Upload/download super cepat, video conference HD tanpa gangguan, dan cloud computing. Support 15-20 perangkat.',
                'status' => 'aktif'
            ],
            [
                'service_name' => 'Paket Premium 300',
                'speed' => 300,
                'price' => 1200000,
                'description' => 'Paket premium untuk pengguna profesional. Streaming 8K, server hosting, backup cloud cepat, dan gaming pro esports. Support unlimited devices.',
                'status' => 'nonaktif' // Default nonaktif, bisa diaktifkan admin
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}