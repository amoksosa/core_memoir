<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGuest extends Model
{
    protected $fillable = [
        'event_id',
        'guest_token',
        'guest_name',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'guest_token', 'guest_token');
    }
}