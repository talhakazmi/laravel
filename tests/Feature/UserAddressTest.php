<?php

namespace Tests\Feature;

use App\User;
use App\UserAddress;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAddressTest extends TestCase
{
	use WithFaker,RefreshDatabase;

    /** @test */
    public function user_can_make_his_address_default()
    {
	    $user =  create(User::class);
	    $this->login($user,NULL,'api');
	    $userAddress = create(UserAddress::class,['user_id' => $user->id]);
        $response = $this->postJson('/api/v1/account/addresses/set/default/' . $userAddress->id,
	        [
	        	'default' => true
	        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users_addresses', [
        	'id' => $userAddress->id,
	        'default' => true,
        ]);
    }

    /** @test */
	public function user_can_only_have_one_default_address()
	{
		$user =  create(User::class);
		$this->login($user,NULL,'api');
		$userAddress = create(UserAddress::class,['user_id' => $user->id]);
		$defaultAddress = create(UserAddress::class,['user_id' => $user->id,'default' => 1]);
		$response = $this->postJson('/api/v1/account/addresses/set/default/' . $userAddress->id,
			[
				'default' => 1
			]);
		$response->assertStatus(200);
		$this->assertDatabaseHas('users_addresses', [
			'id' => $userAddress->id,
			'default' => 1,
		]);
    }
}
