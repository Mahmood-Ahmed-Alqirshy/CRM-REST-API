<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'facebook_id' => $this->facebook_id,
            'instagram_id' => $this->instagram_id,
            'email' => $this->email,
            'location_id' => $this->location_id,
            'birthday' => date_format($this->birthday, 'Y-m-d'),
            'location' => $this->whenLoaded('location', fn() => $this->location->name),
            'interest_ids' => $this->whenLoaded('interests', fn() => $this->interests->pluck('id')->toArray()),
        ];
    }
}
