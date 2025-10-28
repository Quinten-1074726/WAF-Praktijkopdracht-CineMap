<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchlistItem extends Model
{
    protected $fillable = ['user_id', 'title_id', 'status', 'rating', 'review'];

    public function user()  { return $this->belongsTo(User::class); }
    public function title() { return $this->belongsTo(Title::class); }
}