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
            'birthday' => $this->birthday,
            'location' => $this->whenLoaded('location', fn() => $this->location->name),
            //should call with('interests:id') on model
            'interest_ids' => $this->whenLoaded('interests'),
        ];
    }
}
