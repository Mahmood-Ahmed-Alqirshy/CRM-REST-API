<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
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
            'heading' => $this->heading,
            'description' => $this->description,
            'datetime' => $this->datetime,
            'is_annual' => $this->is_annual,
            'image' => $this->image,
            'tag_ids' => $this->whenLoaded('tags', fn() => $this->tags->pluck('id')->toArray()),
            'interest_ids' => $this->whenLoaded('interests', fn() => $this->interests->pluck('id')->toArray()),
        ];
    }
}
