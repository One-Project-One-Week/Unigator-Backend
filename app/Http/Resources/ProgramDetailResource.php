<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'university_id' => $this->university_id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'detail' => $this->detail,
            'degree_type' => $this->degree_type,
            'duration' => $this->duration,
            'intake' => $this->intake,
            'payment_plan' => $this->payment_plan,
            'average_cost' => (float) $this->average_cost,
            'application_requirement' => $this->application_requirement,
            'level' => $this->level,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'universities' => new UniversityResource($this->whenLoaded('universities')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}