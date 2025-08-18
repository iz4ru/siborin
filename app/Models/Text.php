<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Text extends Model
{
    use HasFactory;
    protected $table = 'texts';
    protected $fillable = [
        'text',
    ];
}
