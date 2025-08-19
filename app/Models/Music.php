<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Music extends Model
{
    use HasFactory;
    protected $table = 'music';
    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'music_url',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
