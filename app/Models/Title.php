<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'year',
        'is_published',
        'platform_id'
    ];

    
}
