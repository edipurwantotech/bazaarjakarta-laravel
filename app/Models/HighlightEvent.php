<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class HighlightEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'icon',
    ];

    /**
     * The events that belong to the highlight event.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_highlight_event');
    }
}