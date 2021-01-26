<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Blogs as BlogResource;

class BlogController extends APIController
{

    public function index()
    {
        $blogs = Blog::active()->orderBy('priority')->paginate(15);
        return $this->resource('collection','Api\Blogs', BlogResource::collection($blogs));
    }

    public function details($blogID)
    {
        $blog = Blog::active()->find($blogID);
        return $this->resource('object','Api\Blogs', new BlogResource($blog));
    }

}
