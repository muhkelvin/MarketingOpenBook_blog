<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Menampilkan semua artikel yang terkait dengan tag tertentu
    public function show($slug)
    {
        // Cari tag berdasarkan slug
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // Ambil semua artikel yang memiliki tag ini (asumsi relasi many-to-many sudah diatur di model Tag)
        $articles = $tag->articles()->whereNotNull('published_at')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('tags.show', compact('tag', 'articles'));
    }
}
