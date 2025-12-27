<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    // Pastikan 'featured' ada di sini!
    protected $fillable = [
        'title',
        'description',
        'author',
        'thumbnail_url',
        'video_url',
        'featured', // <--- INI WAJIB ADA
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];
}
