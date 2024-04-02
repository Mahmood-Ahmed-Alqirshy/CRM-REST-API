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
            'facebook_id' => '12531093',
            'instagram_id' => 'mahmoudahmed404',
            'email' => 'mahmood@ahmed.com',
            'location_id' => Location::first()->id,
            'birthday' => now()->subDecade(2)->format('Y-m-d'),
            'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
        ];
    }

    public static function valid() {
        return [
            [
                'name' => 'Mahmoud Ahmed',
                'phone' => '737514829',
                'facebook_id' => '12831093',
                'instagram_id' => 'mahmoodahmed404',
                'email' => 'mahmoud@ahmed.com',
                'location_id' => Location::first()->id,
                'birthday' => now()->subDecade(2)->format('Y-m-d'),
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
                    'facebook_id' => '12831093',
                    'instagram_id' => 'mahmoodahmed404',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birthday' => now()->subDecade(2),
                    'interest_ids' => []
                ],
                'invalidFields' => ['name', 'birthday']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud1212hmed',
                    'phone' => '737514829',
                    'facebook_id' => '12831093',
                    'instagram_id' => 'mahmoodahmed404',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birthday' => now()->subDecade(2),
                ],
                'invalidFields' => ['name', 'birthday']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => Contact::first()->phone,
                    'facebook_id' => Contact::first()->facebook_id,
                    'instagram_id' => Contact::first()->instagram_id,
                    'email' => Contact::first()->email,
                    'location_id' => Location::first()->id,
                    'birthday' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => Interest::take(3)->pluck('id')->toArray()
                ],
                'invalidFields' => ['facebook_id','instagram_id','email', 'phone']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '7375R4829',
                    'facebook_id' => '12831093',
                    'instagram_id' => 'mahmoodahmed404',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => Location::first()->id,
                    'birthday' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => 1
                ],
                'invalidFields' => ['phone', 'interest_ids']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '73754829',
                    'facebook_id' => '12831093',
                    'instagram_id' => 'mahmoodahmed404',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => 'ttt',
                    'birthday' => '2055 2 1',
                    'interest_ids' => 'ggg'
                ],
                'invalidFields' => ['phone', 'birthday', 'interest_ids','location_id']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '737544829',
                    'facebook_id' => '12r831093',
                    'instagram_id' => 'mahmoodahmed40466666666666666666444444444',
                    'email' => 'mahmoudahmed.com',
                    'location_id' => Location::first()->id,
                    'birthday' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => Interest::take(3)->pluck('id')->toArray()
                ],
                'invalidFields' => ['facebook_id','instagram_id','email']
            ],
            [
                'data' => [
                    'name' => 'Mahmoud Ahmed',
                    'phone' => '737514829',
                    'facebook_id' => '12831093',
                    'instagram_id' => 'mahmoodahmed404',
                    'email' => 'mahmoud@ahmed.com',
                    'location_id' => 1000,
                    'birthday' => now()->subDecade(2)->format('Y-m-d'),
                    'interest_ids' => [1000, 2000, Interest::first()->id],
                ],
                'invalidFields' => ['location_id', 'interest_ids.0', 'interest_ids.1']
            ],
        ];
    }
}
