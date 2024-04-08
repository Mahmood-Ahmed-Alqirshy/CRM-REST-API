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
            'social_media_links' => $this->social_media_links,
            'email' => $this->email,
            'location_id' => $this->location_id,
            'birth_date' => date_format($this->birth_date, 'Y-m-d'),
            'location' => $this->whenLoaded('location', fn () => $this->location->name),
            'interest_ids' => $this->whenLoaded('interests', fn () => $this->interests->pluck('id')->toArray()),
        ];
    }
}
