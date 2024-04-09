<?php

namespace App\APINotifications;

use App\Models\Deal;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Messenger
{
    private static function getUsersId(): array
    {
        $response = Http::withUrlParameters([
            'page_id' => config('facebook.page_id'),
        ])
            ->withQueryParameters(
                [
                    'fields' => 'participants',
                    'access_token' => config('facebook.page_access_token'),
                ]
            )
            ->get('https://graph.facebook.com/v19.0/{page_id}/conversations')->json()['data'];

        return array_map(fn ($e) => Arr::get($e, 'participants.data.0.id'), $response);
    }

    public static function send(Deal $deal): void
    {
        $usersIds = static::getUsersId();

        $heading = $deal->heading;
        $description = $deal->description;

        foreach ($usersIds as $id) {

            Http::contentType('application/json')->withUrlParameters([
                'page_id' => config('facebook.page_id'),
            ])->withQueryParameters([
                'access_token' => config('facebook.page_access_token'),
            ])->post('https://graph.facebook.com/v19.0/{page_id}/messages', [
                'recipient' => [
                    'id' => $id,
                ],
                'messaging_type' => 'UPDATE',
                'message' => [
                    'text' => <<<TEXT
                    $heading
                    
                    $description
                    TEXT
                ],
            ]);
            Http::contentType('application/json')->withUrlParameters([
                'page_id' => config('facebook.page_id'),
            ])->withQueryParameters([
                'access_token' => config('facebook.page_access_token'),
            ])->post('https://graph.facebook.com/v19.0/{page_id}/messages', [
                'recipient' => [
                    'id' => $id,
                ],
                'messaging_type' => 'UPDATE',
                'message' => [
                    'attachment' => [
                        'type' => 'image',
                        'payload' => [
                            'url' => $deal->image,
                            'is_reusable' => true,
                        ],
                    ],
                ],
            ]);
        }
    }
}
