<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'developer_id' => 1,
                'title' => 'Artikel Pertama',
                'short_content' => 'Ini adalah artikel pertama yang membahas tentang pengembangan aplikasi web.',
                'content' => 'Konten lengkap dari artikel pertama. Di sini dibahas lebih dalam tentang pengembangan web.',

            ],
            [
                'title' => 'Tips Laravel untuk Pemula',
                'short_content' => 'Beberapa tips dasar untuk mulai belajar Laravel.',
                'content' => 'Konten lengkap dari artikel kedua. Tips mencakup routing, controller, dan blade template.',
            ],
            [
                'developer_id' => 1,
                'title' => 'Mengenal REST API',
                'short_content' => 'Penjelasan mengenai konsep dasar REST API.',
                'content' => 'REST API adalah standar komunikasi antara client dan server. Artikel ini membahas prinsip-prinsip utamanya.',

            ],
            [
                'title' => 'Frontend vs Backend',
                'short_content' => 'Perbandingan antara pengembangan frontend dan backend.',
                'content' => 'Artikel ini menjelaskan perbedaan, kelebihan, dan tantangan masing-masing bidang.',
            ],
        ];
        DB::table('tags')->insert([
            ['name' => 'Laravel'],
            ['name' => 'Web Development'],
            ['name' => 'API'],
            ['name' => 'Frontend'],
            ['name' => 'Backend'],
        ]);
        foreach ($articles as $data) {
            $article = Article::create($data);
            $tagIds = Tag::inRandomOrder()->take(2)->pluck('id')->all();
            $article->tags()->sync($tagIds);
        }
    }
}
