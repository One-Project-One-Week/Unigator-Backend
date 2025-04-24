<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->user->name,
            'logo' => $this->logo,
            'country' => $this->country,
            'description' => $this->description,
            'city' => $this->city,
            'slug' => $this->slug,
            'ranking' => $this->ranking,
            'count' => $this->programs->count(),
            'program_names' => $this->programs->pluck('name')->take(3),
        ];
    }
}
