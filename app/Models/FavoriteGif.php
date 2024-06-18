<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteGif extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'gif_id',
        'alias',
        'user_id',
    ];
}
