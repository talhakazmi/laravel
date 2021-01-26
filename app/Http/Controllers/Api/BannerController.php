<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\Banners as BannerResource;
class BannerController extends APIController
{

    public function index()
    {
        $blogs = Banner::active()->orderBy('priority')->paginate(15);
        return $this->resource('collection','Api\Banners', BannerResource::collection($blogs));
    }
}
