<?php

namespace Tests\Feature;

use App\Cart;
use App\CartDetails;
use App\Delivery;
use App\Order;
use App\OrderDetails;
use App\Setting;
use App\Status;
use App\StatusFlow;
use App\StatusType;
use App\User;
use App\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function user_can_view_his_orders()
    {
        $this->actingAs($user = create(User::class), 'api');
        $orders = factory(Order::class, 5)->create(['user_id' => $user->id]);
        $response = $this->getJson('/api/v1/account/order');
        $response->assertStatus(200);
        foreach ($orders as $order) {
            $response->assertJsonFragment(['orderID' => $order->orderID, 'created_at' => $order->created_at]);
        }
    }

    /** @test */
    public function user_can_view_a_single_orders()
    {
        $this->actingAs($user = create(User::class), 'api');
        $order = create(Order::class, ['user_id' => $user->id]);
        $response = $this->getJson('/api/v1/account/order/' . $order->orderID);
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'orderID' => $order->orderID,
            'date' => $order->created_at->diffForHumans(),
            'userName' => $order->Users->name
        ]);
    }


    /** @test */
    public function order_gets_store_for_each_shop()
    {
        $this->EstablishFirstStatus();
        $cartDetails =  factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $this->actingAs($user = create(User::class),'api');
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'deliveryID' => create(Delivery::class)->deliveryID,
            'users_addresses_id' => create(UserAddress::class)->id,
            'status_statusID' => create(Status::class)->statusID
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Order created successfully']);
        foreach ($cartDetails as $cart) {
            $this->assertDatabaseHas('orders', [
                'shops_shopID' => $cart->Product->shops_shopID,
                'user_id' => $user->id,
            ]);
        }
    }

    /** @test */
    public function user_can_make_order()
    {
        $this->EstablishFirstStatus();
        $cartDetails =  factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $this->actingAs(create(User::class),'api');
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'deliveryID' => create(Delivery::class)->deliveryID,
            'users_addresses_id' => create(UserAddress::class)->id,
            'status_statusID' => create(Status::class)->statusID
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Order created successfully']);
        foreach ($cartDetails as $cart) {
            $this->assertDatabaseHas('order_items', [
                'shops_shopID' => $cart->Product->shops_shopID,
                'products_productID' => $cart->product->productID,
                'cost' => $cart->product->costs,
                'price' => $cart->product->price,
                'quantity' => $cart->quantity,
                'subPrice' => $cart->product->price * $cart->quantity,
                'totalCost' => $cart->product->costs * $cart->quantity
            ]);
        }
    }
    /** @test */
    public function user_needs_to_be_authorized_to_make_orders()
    {
        factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'deliveryID' => create(Delivery::class)->deliveryID,
            'users_addresses_id' => create(UserAddress::class)->id,
            'status_statusID' => create(Status::class)->statusID
        ]);

        $response->assertStatus(401);

    }

    /** @test */
    public function user_needs_to_add_address()
    {
        factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $this->actingAs(create(User::class),'api');
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'deliveryID' => create(Delivery::class)->deliveryID,
            'status_statusID' => create(Status::class)->statusID
        ]);

        $response->assertStatus(401)
            ->assertJson(['error' =>['users_addresses_id' => ['The users addresses id field is required.']]]);
    }

    /** @test */
    public function user_needs_to_add_delivery()
    {
        factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $this->actingAs(create(User::class),'api');
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'status_statusID' => create(Status::class)->statusID,
            'users_addresses_id' => create(UserAddress::class)->id,

        ]);

        $response->assertStatus(401)
            ->assertJson(['error' =>['deliveryID' => ['The delivery i d field is required.']]]);
    }

    /** @test */
    public function cant_place_order_if_no_status_flow_added()
    {
        factory(CartDetails::class,20)->create(['carts_cartID' => $cartID = create(Cart::class)->cartID]);
        $this->actingAs(create(User::class),'api');
        $response = $this->postJson('/api/v1/checkout/store', [
            'cartID' => $cartID,
            'deliveryID' => create(Delivery::class)->deliveryID,
            'users_addresses_id' => create(UserAddress::class)->id,
            'status_statusID' => create(Status::class)->statusID
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'This service is currently not available']);
    }

    private function EstablishFirstStatus(){
        $statusFlow = create(StatusFlow::class);
        $statusType = create(StatusType::class, ['id' => 1, 'name' => 'start']);
        create(Status::class,  ['status_flow' => $statusFlow->id, 'status_type' => $statusType->id]);
        create(Setting::class, ['id' => 1,'status_flow' => $statusFlow->id]);
    }
}
