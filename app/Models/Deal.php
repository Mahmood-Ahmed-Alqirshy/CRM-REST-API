<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Deal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'heading',
        'description',
        'datetime',
        'is_annual',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'datetime' => 'datetime:Y-m-d H:i:s',
        'is_annual' => 'boolean',
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getTagIdsAttribute()
    {
        return $this->tags()->pluck('id')->toArray();
    }
}
