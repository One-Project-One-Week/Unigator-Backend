<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversityDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->user),
            'logo' => $this->logo,
            'description' => $this->description,
            'country' => $this->country,
            'city' => $this->city,
            'cover' => $this->cover,
            'slug' => $this->slug,
            'ranking' => $this->ranking,
            'rating' => $this->ratings_avg_rating_rate,
            'type' => $this->type,
            'founded' => $this->founded,
            'no_of_students' => $this->no_of_students,
            'website_link' => $this->website_link,
            'image' => $this->image,
            'programs' => ProgramResources::collection($this->whenLoaded('programs')),
            'accommodations' => AccomodationResource::collection($this->whenLoaded('accommodations')),
            'similar_universities' => UniversityResource::collection($this->resource->similar_universities)
        ];
    }
}