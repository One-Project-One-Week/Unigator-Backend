<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProgramResource;

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
            'logo' => $this->logo ? 'logos/' . $this->logo : null,
            'description' => $this->description,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'cover' => $this->cover ? 'covers/' . $this->cover : null,
            'slug' => $this->slug,
            'ranking' => $this->ranking,
            'rating' => $this->ratings_avg_rating_rate,
            'type' => $this->type,
            'founded' => $this->founded,
            'no_of_students' => $this->no_of_students,
            'website_link' => $this->website_link,
            'image' => $this->image ? collect($this->image)->map(function ($img) {
                return 'images/' . $img;
            })->toArray() : [],
            'programs' => ProgramResource::collection($this->whenLoaded('programs')),
            'accommodations' => AccomodationResource::collection($this->whenLoaded('accommodations')),
            'similar_universities' => UniversityResource::collection($this->resource->similar_universities) ?? collect(),
            'levels' => $this->when(isset($this->levels), $this->levels),

            "application_link" => $this->application_link,
        ];
    }
}
