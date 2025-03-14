<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'image',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }



    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        // Jika value adalah ID Imgur
        if (strpos($value, 'http') === false) {
            return "https://i.imgur.com/{$value}.png";
        }

        // Jika sudah URL lengkap
        return $value;
    }
}
