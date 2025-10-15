<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
    
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
