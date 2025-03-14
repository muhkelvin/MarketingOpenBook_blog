<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;

// Homepage: Daftar artikel terbaru
Route::get('/', [ArticleController::class, 'index'])->name('home');

// Resource route untuk artikel (index dan show)
Route::resource('articles', ArticleController::class)->only([
    'index', 'show'
]);

// Route untuk menampilkan artikel berdasarkan tag
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');

// Halaman statis About dan Contact
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
// Route untuk menyimpan data contact
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Route untuk menyimpan data subscribe
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');

// Route untuk menampilkan artikel berdasarkan kategori
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
