<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Contact extends Model
{
    use HasFactory;

    // protected $appends = ['interests'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'facebook_id',
        'instagram_id',
        'email',
        'location_id',
        'birthday',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'facebook_id' => 'integer',
        'location_id' => 'integer',
        'birthday' => 'date:Y-m-d',
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
}
