<?php

// app/Models/Option.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'show_images',
        'show_videos',
        'show_musics',
        'show_texts',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}