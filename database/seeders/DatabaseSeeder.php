<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 10 tag
        $tags = Tag::factory(10)->create();

        // Buat 20 artikel
        Article::factory(20)->create()->each(function ($article) use ($tags) {
            // Ambil beberapa tag secara acak untuk tiap artikel
            $article->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
