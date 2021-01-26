<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function user_can_view_his_details()
    {
        $this->actingAs($user = create(User::class),'api');
        $response = $this->get('/api/v1/user');
        $response->assertStatus(200)
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'DOB' => $user->DOB
            ]);
    }

    /** @test */
    public function guest_can_be_user_when_adding_to_cart_based_if_email_is_added()
    {
        $this->actingAs(create(User::class, ['email' => '']),'api');
        $response = $this->get('/api/v1/user');
        $response->assertJson(['email' => '']);
    }

    /** @test */
    public function guest_can_register_manual_and_be_not_guest()
    {
        $this->actingAs($user = create(User::class),'api');
        $response = $this->get('/api/v1/user');
        $response->assertJson(['email' => $user->email]);
    }
}
