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
            'role' => $this->user->role,
            'logo' => $this->logo,
            'country' => $this->country,
            'description' => $this->description,
            'city' => $this->city,
            'type' => $this->type,
            'slug' => $this->slug,
            'ranking' => $this->ranking,
            'rating' => $this->ratings_avg_rating_rate,
            'count' => $this->programs->count(),
            'program_names' => $this->programs->pluck('name')->take(3),
            'application_link' => $this->application_link,


        ];
    }
}
