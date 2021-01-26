<?php

namespace Tests\Unit;

use App\City;
use App\Country;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function city_has_attribute()
    {

        $country = create(Country::class);

        $city = create(City::class, [
            'name_en' => 'Amman',
            'name_ar' => 'عمان',
            'countries_countryID' => $country->countryID,
            'status' => 1
        ]);

        $this->assertEquals($city->name_en, 'Amman');
        $this->assertEquals($city->name_ar, 'عمان');
        $this->assertEquals($city->countries_countryID,$country->countryID);
        $this->assertEquals($city->status, 1);
    }

    /** @test * */
    public function city_belongs_to_country()
    {
        $city = create(City::class);

        $this->assertInstanceOf(Country::class, $city->Country);
    }

}
