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
            'is_annual' => false,
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
                'is_annual' => false,
                'image' => 'pizza.png',
                'tag_ids' => Tag::take(3)->pluck('id')->toArray(),
                'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
            ],
            [
                'heading' => 'good burger',
                'description' => 'i will be honest it is good',
                'datetime' => now()->addWeek(3)->format('Y-m-d H:i:s'),
                'tag_ids' => [],
                'interest_ids' => [],
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
                    'is_annual' => 'g',
                    'image' => 'pizza.png',
                    'tag_ids' => [],
                    'interest_ids' => [],    
                ],
                'invalidFields' => ['datetime', 'is_annual']
            ],
            [
                'data' => [
                    'tag_ids' => Tag::take(3)->pluck('id')->toArray(),
                    'interest_ids' => Interest::take(3)->pluck('id')->toArray(),
                ],
                'invalidFields' => ['heading', 'description', 'datetime']
            ],
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => 2,
                    'is_annual' => 'g',
                    'image' => 'pizza.png',
                ],
                'invalidFields' => ['interest_ids', 'tag_ids', 'datetime', 'is_annual']
            ],
            [
                'data' => [
                    'heading' => 'good burger',
                    'description' => 'i will be honest it is good',
                    'datetime' => now()->addWeek(3),
                    'is_annual' => true,
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
                    'is_annual' => false,
                    'image' => 'pizza.png',
                    'tag_ids' => [...Tag::take(3)->pluck('id')->toArray(), 400],
                    'interest_ids' => [...Interest::take(3)->pluck('id')->toArray(), 500, 900],
                ],
                'invalidFields' => ['datetime', 'tag_ids.3', 'interest_ids.3', 'interest_ids.4']
            ],
        ];
    }
}
