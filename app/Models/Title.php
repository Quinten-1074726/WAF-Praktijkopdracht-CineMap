<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'title_genre');
    }

    public function watchlistItems()
    {
        return $this->hasMany(WatchlistItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/'.$this->image);
        }
        return asset('images/placeholder-title.jpg');
    }
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'year',
        'is_published',
        'platform_id',
        'image',
    ];
    
    protected $casts = [
    'is_published' => 'boolean',
    'year' => 'integer',
    'image' => 'string',
    ];

}
