<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua artikel dalam kategori tertentu
    public function index()
    {
        $categories = Tag::withCount('articles')->get();
        return view('categories.index', compact('categories'));

    }
}
