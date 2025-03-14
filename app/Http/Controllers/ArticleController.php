<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Menampilkan daftar artikel terbaru (Homepage)
    public function index()
    {
        // Ambil artikel yang sudah dipublikasikan atau langsung dipublish,
        // artinya published_at bernilai null (langsung publish) atau published_at <= now()
        $articles = Article::where(function ($query) {
            $query->whereNull('published_at')
                ->orWhere('published_at', '<=', now());
        })
            ->orderBy('published_at', 'desc')
            ->paginate(10); // Ubah sesuai kebutuhan

        return view('articles.index', compact('articles'));
    }


    // Menampilkan detail sebuah artikel berdasarkan slug
    public function show($slug)
    {
        // Cari artikel berdasarkan slug, jika tidak ditemukan akan menghasilkan error 404
        $article = Article::where('slug', $slug)->firstOrFail();

        return view('articles.show', compact('article'));
    }
}
