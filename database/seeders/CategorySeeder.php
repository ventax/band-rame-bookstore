<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Koleksi buku fiksi dan novel terbaik',
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku non-fiksi, biografi, dan sejarah',
            ],
            [
                'name' => 'Bisnis & Ekonomi',
                'description' => 'Buku tentang bisnis, keuangan, dan ekonomi',
            ],
            [
                'name' => 'Teknologi & Komputer',
                'description' => 'Buku tentang programming, IT, dan teknologi',
            ],
            [
                'name' => 'Pengembangan Diri',
                'description' => 'Buku self-help dan motivasi',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku pelajaran dan pendidikan',
            ],
            [
                'name' => 'Agama & Spiritualitas',
                'description' => 'Buku tentang agama dan spiritualitas',
            ],
            [
                'name' => 'Anak-anak',
                'description' => 'Buku untuk anak-anak dan remaja',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
            ]);
        }
    }
}
