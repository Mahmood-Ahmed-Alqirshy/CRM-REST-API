<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
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

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public static function seeds()
    {
        return [
            ['name' => 'المنصورة'],
            ['name' => 'الشيخ عثمان'],
            ['name' => 'دار سعد'],
            ['name' => 'البريقة'],
            ['name' => 'التواهي'],
            ['name' => 'المعلا'],
            ['name' => 'كريتر'],
            ['name' => 'خور مكسر'],
        ];
    }
}
