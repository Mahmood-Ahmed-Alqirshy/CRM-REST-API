<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Deal;
use App\Models\Interest;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'المنصورة'],
            ['name' => 'الشيخ عثمان'],
            ['name' => 'دار سعد'],
            ['name' => 'البريقة'],
            ['name' => 'التواهي'],
            ['name' => 'المعلا'],
            ['name' => 'كريتر'],
            ['name' => 'خور مكسر'],
        ];

        $interests = [
            ['name' => 'عيد الميلاد'],
            ['name' => 'عطلة نهاية الأسبوع'],
            ['name' => 'عيد العمال'],
            ['name' => 'عيد الفطر'],
            ['name' => 'رمضان'],
            ['name' => 'المأكولات البحرية'],
        ];

        $tags = [
            ['name' => 'رمضانيات'],
            ['name' => 'شعبي'],
            ['name' => 'حلويات'],
            ['name' => 'دسم'],
            ['name' => 'رز'],
            ['name' => 'بيتزا'],
            ['name' => 'جديد'],
            ['name' => 'حق مزوجين'],
        ];

        foreach($interests as $interest)
            Interest::factory()->create($interest);

        foreach($tags as $tag)
            Tag::factory()->create($tag);

        foreach($locations as $location)
            Location::factory()->create($location);
    }
}
