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
            'user' => UserResource::make($this->user),
            'logo' => $this->logo,
            'country' => $this->country,
            'city' => $this->city,
            'slash' => $this->slash,
            'ranking' => $this->ranking,
        ];
    }
}
