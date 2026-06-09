<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
    'name',
    'code',
    'event_date',
    'photo_limit',
    'guest_limit',
    'reveal_at',
    'is_active',
    'theme',
    'background_image',
    'background_photographer',
    'background_photographer_url',
    'template',
    'photo_frame',
    'font_style',
    'caption',
];

    public function photos()
{
    return $this->hasMany(Photo::class);
}

public function guests()
{
    return $this->hasMany(EventGuest::class);
}
}