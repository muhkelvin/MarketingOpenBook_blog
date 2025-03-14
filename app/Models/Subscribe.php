<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    /** @use HasFactory<\Database\Factories\SubscribeFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
    ];
}
