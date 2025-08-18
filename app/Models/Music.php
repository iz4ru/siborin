<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Music extends Model
{
    use HasFactory;
    protected $table = 'music';
    protected $fillable = [
        'filename',
        'path',
        'music_url',
    ];
}
