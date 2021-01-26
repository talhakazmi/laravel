<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use App\Http\Resources\Api\v1\Specialties as SpecialtyResource;
class Brands extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'brandID' => $this->brandID,
            'name' => $this->name,
            'content' => $this->content,
            'status' => $this->status,
            'priority' => $this->priority,
            'logo' => $this->logo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'specialties' => SpecialtyResource::collection($this->whenLoaded('specialty'))
        ];
    }
}
