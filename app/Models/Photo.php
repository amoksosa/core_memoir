<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = [
        'event_id',
        'image_path',
        'guest_name',
        'guest_token',
    ];

    protected $appends = [
        'image_url',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}