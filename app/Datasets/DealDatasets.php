<?php

namespace App\Datasets;

use App\Models\Interest;
use App\Models\Tag;

class DealDatasets
{
    public static function update()
    {
        return [
            'heading' => 'very good burger',
            'description' => 'i will be honest it is good',
            'datetime' => now()->addWeek(3)->format('Y-m-d H:i:s'),
            'annual' => false,
            'image' => 'pizza.png',
            'tag_ids' => Tag::take(3)->pluck('id')->toArray(),
            'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
        ];
    }

    public static function valid()
    {
        return [
            [
                'heading' => 'good burger',
                'description' => 'i will be honest it is good',
                'datetime' => now()->addWeek(3)->format('Y-m-d H:i:s'),
                'annual' => false,
                'image' => 'pizza.png',
                'tag_ids' => Tag::take(3)->pluck('id')->toArray(),
                'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
            ],
        ];
    }

    public static function invalid()
    {
        return [
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => 2,
                    'annual' => 'g',
                    'image' => 'pizza.png',
                    'tag_ids' => [],
                    'interest_ids' => [],    
                ],
                'invalidFields' => ['datetime', 'annual']
            ],
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => 2,
                    'annual' => 'g',
                    'image' => 'pizza.png',
                ],
                'invalidFields' => ['datetime', 'annual']
            ],
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => now()->addWeek(3),
                    'annual' => true,
                    'image' => 'pizza.png',
                    'tag_ids' => Tag::take(3)->pluck('id')->toArray(),
                    'interest_ids' => Interest::take(3)->pluck('id')->toArray(),    
                ],
                'invalidFields' => ['datetime']
            ],
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => 2,
                    'annual' => false,
                    'image' => 'pizza.png',
                    'tag_ids' => [...Tag::take(3)->pluck('id')->toArray(), 400],
                    'interest_ids' => [...Interest::take(3)->pluck('id')->toArray(), 500, 900],
                ],
                'invalidFields' => ['datetime', 'tag_ids.3', 'interest_ids.3', 'interest_ids.4']
            ],
        ];
    }
}
