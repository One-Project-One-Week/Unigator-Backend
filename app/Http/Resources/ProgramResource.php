<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class ProgramResource extends JsonResource
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
            // 'category' => CategoryResource::make($this->whenLoaded('category')),
            'detail' => $this->detail,
            // 'detail' => json_decode($this->detail),
            'degree_type' => $this->degree_type,
            'duration' => $this->duration,
            // 'application_requirement' => json_decode($this->application_requirement),
            'intake' => $this->intake,
            'payment_plan' => $this->payment_plan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}