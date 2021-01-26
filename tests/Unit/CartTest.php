<?php

namespace Tests\Unit;

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


    /** @test */
    public function cart_has_attribute()
    {
        $cart = create(Cart::class,[
            'user_id' => $user_id = create(User::class)->id,
            'shops_shopID' => $shops_shopID = create(Shop::class)->shopID
        ]);
        $this->assertEquals($cart->user_id, $user_id);
        $this->assertEquals($cart->shops_shopID, $shops_shopID);
    }

    /** @test */
    public function cart_details_has_attribute(){
        $cartDetails = create(CartDetails::class,[
            'carts_cartID' => $cartID = create(Cart::class)->cartID,
            'products_productID' => $productID = create(Product::class)->productID,
            'quantity' => $quantity = $this->faker->randomNumber(2),
            'options' => $options = [],
            'promoCode' => $promoCode = 'test',
            'DiscountPerc' => $discountPerc = 20,
            'DiscountVal' => $discountVal = 10
        ]);
        $this->assertEquals($cartDetails->carts_cartID, $cartID);
        $this->assertEquals($cartDetails->products_productID, $productID);
        $this->assertEquals($cartDetails->quantity, $quantity);
        $this->assertEquals($cartDetails->options, $options);
        $this->assertEquals($cartDetails->promoCode, $promoCode);
        $this->assertEquals($cartDetails->DiscountPerc, $discountPerc);
        $this->assertEquals($cartDetails->DiscountVal, $discountVal);
    }

    /** @test * */
    public function cart_belongs_to_user()
    {
        $cart = create(Cart::class, ['user_id' => create(User::class)->id]);
        $this->assertInstanceOf(User::class, $cart->User);
    }

    /** @test */
    public function cart_belongs_to_shop()
    {
        $cart = create(Cart::class, ['shops_shopID' => create(Shop::class)->shopID]);
        $this->assertInstanceOf(Shop::class, $cart->Shop);
    }

    /** @test * */
    public function cart_details_belongs_to_cart()
    {
        $cartDetails = create(CartDetails::class);

        $this->assertInstanceOf(Cart::class, $cartDetails->Cart);
    }

    /** @test * */
    public function cart_details_belongs_to_product()
    {
        $cartDetails = create(CartDetails::class);

        $this->assertInstanceOf(Product::class, $cartDetails->Product);
    }
}
