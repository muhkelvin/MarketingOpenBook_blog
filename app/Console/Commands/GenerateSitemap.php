<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Article;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap for the website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Buat instance sitemap
        $sitemap = Sitemap::create();

        // Tambahkan halaman statis
        $sitemap->add(Url::create(url('/'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0)
        );

        $sitemap->add(Url::create(url('/about'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8)
        );

        $sitemap->add(Url::create(url('/contact'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.8)
        );

        // Tambahkan halaman artikel secara dinamis
        $articles = Article::whereNotNull('published_at')->get();
        foreach ($articles as $article) {
            $sitemap->add(
                Url::create(route('articles.show', $article->slug))
                    ->setLastModificationDate($article->published_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            );
        }

        // Simpan sitemap.xml ke folder public
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
