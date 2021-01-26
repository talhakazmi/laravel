<?php

namespace Tests\Unit;

use App\Delivery;
use App\Shop;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /** @test */
    public function user_has_attribute()
    {
        $user = create(User::class,[
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email,
            'password' => $password = $this->faker->password,
            'phone' => $phone = $this->faker->phoneNumber,
            'gender' => $gender = 'M',
            'DOB' => $DOB = $this->faker->date()
        ]);
        $this->assertEquals($user->name, $name);
        $this->assertEquals($user->email, $email);
        $this->assertEquals($user->password, $password);
        $this->assertEquals($user->phone, $phone);
        $this->assertEquals($user->gender, $gender);
        $this->assertEquals($user->DOB, $DOB);
    }
}
