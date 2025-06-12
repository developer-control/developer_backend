<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $promotions = [
            [
                'developer_id' => 1,
                'title' => 'Artikel Pertama',
                'content' => 'Konten lengkap dari artikel pertama. Di sini dibahas lebih dalam tentang pengembangan web.',
                'is_active' => 1
            ],
            [
                'title' => 'Tips Laravel untuk Pemula',
                'content' => 'Konten lengkap dari artikel kedua. Tips mencakup routing, controller, dan blade template.',
                'is_active' => 1
            ],
            [
                'developer_id' => 1,
                'title' => 'Mengenal REST API',
                'content' => 'REST API adalah standar komunikasi antara client dan server. Artikel ini membahas prinsip-prinsip utamanya.',
                'is_active' => 1
            ],
            [
                'title' => 'Frontend vs Backend',
                'content' => 'Artikel ini menjelaskan perbedaan, kelebihan, dan tantangan masing-masing bidang.',
                'is_active' => 1
            ],
        ];

        foreach ($promotions as $data) {
            Promotion::create($data);
        }
    }
}
