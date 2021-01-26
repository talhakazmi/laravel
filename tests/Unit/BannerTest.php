<?php

namespace Tests\Unit;

use App\Banner;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BannerTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /** @test */
    public function banner_has_attribute()
    {
        $banner = create(Banner::class, [
            'bannerImage_en' => $bannerImage_en = $this->faker->name,
            'bannerImage_ar' => $bannerImage_ar = $this->faker->name,
            'bannerLink' => $bannerLink = $this->faker->text(50),
            'status' => 1,
            'priority' => 1,
            'link' => $link = $this->faker->text(50),
        ]);
        $this->assertEquals($banner->bannerImage_en, $bannerImage_en);
        $this->assertEquals($banner->bannerImage_ar, $bannerImage_ar);
        $this->assertEquals($banner->bannerLink, $bannerLink);
        $this->assertEquals($banner->status, 1);
        $this->assertEquals($banner->priority, 1);
        $this->assertEquals($banner->link, $link);
    }
}
