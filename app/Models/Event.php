<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'start_date',
        'end_date',
        'time',
        'location',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'time' => 'datetime:H:i:s',
    ];

    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the categories for the event.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(EventCategory::class, 'event_event_category', 'event_id', 'category_id');
    }

    /**
     * Get the galleries for the event.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * The highlight events that belong to the event.
     */
    public function highlightEvents(): BelongsToMany
    {
        return $this->belongsToMany(HighlightEvent::class, 'event_highlight_event');
    }
}