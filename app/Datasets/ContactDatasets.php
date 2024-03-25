<?php

namespace App\Datasets;

use App\Models\Contact;
use App\Models\Interest;
use App\Models\Location;

class ContactDatasets
{
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
                    'birthday' => now()->subDecade(2)->format('Y-m-d'),
                    'interests' => Interest::take(3)->pluck('id')->toArray()
                ],
                'invalidFields' => ['name']
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
                    'interests' => Interest::take(3)->pluck('id')->toArray()
                ],
                'invalidFields' => ['facebook_id','instagram_id','email','phone']
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
                    'interests' => 1
                ],
                'invalidFields' => ['phone', 'interests']
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
                    'interests' => 'ggg'
                ],
                'invalidFields' => ['phone', 'birthday', 'interests','location_id']
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
                    'interests' => Interest::take(3)->pluck('id')->toArray()
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
                    'interests' => [1000, 2000, Interest::first()->id],
                ],
                'invalidFields' => ['location_id', 'interests.0', 'interests.1']
            ],
        ];
    }
}
