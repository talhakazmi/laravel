<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class Blogs extends JsonResource
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
            'blogID' => $this->blogID,
            'author' => $this->author,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'status' => $this->status,
            'priority' => $this->priority,
            'image' => $this->image,
            'reviews' => $this->Reviews,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'meta' => $this->Meta,
            'tags' => $this->Tags,
            'categories' => $this->Categories,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'content_en' => $this->content_en,
            'content_ar' => $this->content_ar
        ];
    }
}
