<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    protected $hidden = ['updated_at', 'created_at'];

    public function deals(): BelongsToMany
    {
        return $this->belongsToMany(Deal::class);
    }

    public static function seeds() {
        return [
            ['name' => 'رمضانيات'],
            ['name' => 'شعبي'],
            ['name' => 'حلويات'],
            ['name' => 'دسم'],
            ['name' => 'رز'],
            ['name' => 'بيتزا'],
            ['name' => 'جديد'],
            ['name' => 'حق مزوجين'],
        ];
    }
}
