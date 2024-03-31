<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Interest extends Model
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

    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class);
    }

    public static function seeds() {
        return [
            ['name' => 'عيد الميلاد'],
            ['name' => 'عطلة نهاية الأسبوع'],
            ['name' => 'عيد العمال'],
            ['name' => 'عيد الفطر'],
            ['name' => 'رمضان'],
            ['name' => 'المأكولات البحرية'],
        ];
    }
}
