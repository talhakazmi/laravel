<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class Banners extends JsonResource
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
            'bannerID'   => $this->bannerID,
            'name'       => $this->name,
            'image'      => $this->bannerLink,
            'link'       => $this->link,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
