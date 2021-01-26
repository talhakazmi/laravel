<?php

namespace Tests\Feature;

use App\Banner;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test  */
    public function guest_can_view_banners()
    {
        $banners = factory(Banner::class,10)->create();
        $response = $this->get('/api/v1/banners');
        $response->assertStatus(200);
        foreach ( $banners as $banner) {
            $response->assertJsonFragment([
                'bannerID' => $banner->bannerID,
                'name'       => $banner->name,
                'image'      => $banner->bannerLink,
                'link'       => $banner->link,
                'created_at' => $banner->created_at,
                'updated_at' => $banner->updated_at
            ]);
        }
    }
}
