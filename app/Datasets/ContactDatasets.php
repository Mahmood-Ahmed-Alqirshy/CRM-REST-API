<?php

namespace App\Datasets;

use App\Models\Contact;
use App\Models\Interest;
use App\Models\Location;

class ContactDatasets
{
    public static function update() {
        return [
            'name' => 'Ahmed Mahmoud',
            'phone' => '777514829',
            'social_media_links' => '{ "facebook": "https://www.facebook.com/456466", "instagram": "https://www.instagram.com/example0" }',
            'email' => 'mahmood@ahmed.com',
            'location_id' => Location::first()->id,
            'birth_date' => now()->subDecade(2)->format('Y-m-d'),
            'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
        ];
    }

    public static function valid() {
        return [
            [
                'name' => 'Mahmoud Ahmed',
                'phone' => '737514829',
                'social_media_links' => '{ "facebook": "https://www.facebook.com/14083", "instagram": "https://www.instagram.com/example1" }',
                'email' => 'mahmoud@ahmed.com',
                'location_id' => Location::first()->id,
                'birth_date' => now()->subDecade(2)->format('Y-m-d'),
                'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
            ],
        ];
    }

    public static function invalid() {
        return [
            [
                'data' => [
                    'name' => 'Mahmoud1212hmed',
                    'phone' => '737514829',
                    'social_media_links' => 1,
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birth_date' => now()->subDecade(2),
                    'interest_ids' => []
                ],
                'invalidFields' => ['social_media_links' ,'name', 'birth_date']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud1212hmed',
                    'phone' => '737514829',
                    'social_media_links' => '{ "facebook": "https://www.facebook.com/11001", "instagram": "https://www.instagram.com/example2" }',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birth_date' => now()->subDecade(2),
                ],
                'invalidFields' => ['interest_ids', 'name', 'birth_date']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => Contact::first()->phone,
                    'social_media_links' => 'tttt',
                    'email' => Contact::first()->email,
                    'location_id' => Location::first()->id,
                    'birth_date' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => Interest::take(3)->pluck('id')->toArray()
                ],
                'invalidFields' => ['social_media_links', 'email', 'phone']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '7375R4829',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birth_date' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => 1
                ],
                'invalidFields' => ['phone', 'interest_ids']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '73754829',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => 'ttt',
                    'birth_date' => '2055 2 1',
                    'interest_ids' => 'ggg'
                ],
                'invalidFields' => ['phone', 'birth_date', 'interest_ids','location_id']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '737514829',
                    'email' => 'mmahmoudahmed.com',
                    'location_id' => 1000,
                    'birth_date' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => [1000, 2000, Interest::first()->id],
                ],
                'invalidFields' => ['location_id', 'interest_ids.0', 'interest_ids.1', 'email']
            ],
        ];
    }
}