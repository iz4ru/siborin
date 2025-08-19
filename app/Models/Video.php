<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'video_url',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
