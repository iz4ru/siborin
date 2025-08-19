<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'image_url',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
