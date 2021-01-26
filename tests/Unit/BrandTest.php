<?php

namespace Tests\Unit;

use App\brand;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
{
    use WithFaker,RefreshDatabase;


    /** @test */
    public function brand_has_attributes()
    {
        $brand = create(brand::class,[
            'name_en'    => $name_en = $this->faker->text(100),
            'name_ar'    => $name_ar = $this->faker->text(100),
            'content_en' => $content_en = $this->faker->text,
            'status'     => $status = RAND(0,1),
            'priority'   => $priority = RAND(1,9),
            'logo'       => $logo = $this->faker->text(100)
        ]);
        $this->assertEquals($brand->name_en, $name_en);
        $this->assertEquals($brand->name_ar, $name_ar);
        $this->assertEquals($brand->content_en, $content_en);
        $this->assertEquals($brand->status, $status);
        $this->assertEquals($brand->priority, $priority);
        $this->assertEquals($brand->logo, $logo);
    }
}
