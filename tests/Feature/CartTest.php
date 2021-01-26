<?php

namespace Tests\Feature;

use App\Cart;
use App\CartDetails;
use App\Product;
use App\Shop;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    protected $cartIdentifier;
    protected $productID;
    protected $cartDetails;

    public function setUp(): void
    {
        parent::setUp();
        $this->cartDetails = create(CartDetails::class,
            [
                'carts_cartID' => $this->cartIdentifier = create(Cart::class)->cartID,
                'products_productID' => $this->productID = create(Product::class)->productID
            ]);

    }


    /** @test */
    public function guest_can_add_items_to_cart()
    {
        $response = $this->postJson('/api/v1/cart/add',[
            'productID' => create(Product::class)->productID,
            'quantity' => 1,
            'shops_shopID' => create(Shop::class)->shopID
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product was added successfully']);
    }

    /** @test */
    public function guest_can_update_item_to_cart()
    {
        $response = $this->postJson('/api/v1/cart/add',[
            'productID' => $this->productID,
            'quantity' => 1,
            'cartIdentifier' => $this->cartIdentifier
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product was updated successfully']);
    }

    /** @test */
    public function guest_can_view_cart(){
        $response = $this->getJson('/api/v1/cart/retrieve',['cartIdentifier' => $this->cartIdentifier]);
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_delete_item_in_cart(){
        $response = $this->getJson('/api/v1/cart/delete/' . $this->cartDetails->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_erase_cart(){
        $response = $this->getJson('/api/v1/cart/clear/' . $this->cartIdentifier);
        $response->assertStatus(200);
    }
    /** @test */
    public function guest_can_login_and_still_has_cart(){
        $this->actingAs(create(User::class),'api');
        $this->getJson('/api/v1/cart/updateowner/' . $this->cartIdentifier)
            ->assertStatus(200)
            ->assertJson(['message' => 'Owner was updated']);
    }
    /** @test */
    public function guest_can_update_quantity_of_cart_item(){
	    $this->actingAs(create(User::class),'api');
	    $this->postJson('/api/v1/cart/quantity/' . $this->cartDetails->id,[
    		'operation' => '+',
		    'quantity' => 1
	    ])->assertStatus(200);
    }
}
