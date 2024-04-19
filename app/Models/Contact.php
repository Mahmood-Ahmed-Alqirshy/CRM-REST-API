<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use HasFactory, Notifiable;

    // protected $appends = ['interests'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'social_media_links',
        'email',
        'location_id',
        'birth_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'social_media_links' => 'array',
        'location_id' => 'integer',
        'birth_date' => 'date:Y-m-d',
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class);
    }

    public function getInterestIdsAttribute()
    {
        return $this->interests()->pluck('id')->toArray();
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get all contacts that share interests with the deal
     */
    public static function getByDeal(Deal $deal)
    {
        return Contact::with('interests')->whereHas('interests', fn ($query) => $query->whereIn('id', $deal->interests->pluck('id')->toArray()))
            ->get();
    }
}
