<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Artisan;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        // Jika field published_at berubah dan artikel sudah dipublish, generate sitemap
        if ($article->wasChanged('published_at')
            && $article->published_at
            && now()->greaterThanOrEqualTo($article->published_at)) {
            Artisan::call('app:generate-sitemap');
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
