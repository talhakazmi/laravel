<?php

namespace Tests\Unit;

use App\PromoCode;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PromcodeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function promocode_has_attribute()
    {
        $promocode = create(PromoCode::class,[
            'promoCode' => $code = $this->faker->text(20),
            'promoDisPerc' => $percentage = $this->faker->randomNumber(2),
            'status' => $status = RAND(0,1),
            'type' => $type = $this->faker->randomNumber(1),
        ]);
        $this->assertEquals($promocode->promoCode,$code);
        $this->assertEquals($promocode->promoDisPerc, $percentage);
        $this->assertEquals($promocode->status, $status);
        $this->assertEquals($promocode->type, $type);
    }
}
