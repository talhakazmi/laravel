<?php

namespace Tests\Feature;

use App\FavouriteDetails;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Favourite;
use App\Product;

class FavouriteTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    protected $favouriteIdentifier;
    protected $productID;
    protected $favouriteDetails;

    public function setUp(): void
    {
        parent::setUp();
        $this->favouriteDetails = create(FavouriteDetails::class,
            [
                'favourites_favouriteID' => $this->favouriteIdentifier = create(favourite::class)->favouriteID,
                'products_productID' => $this->productID = create(Product::class)->productID
            ]);

    }


    /** @test */
    public function guest_can_add_items_to_favourite()
    {
        $response = $this->postJson('/api/v1/favourite/add',[
            'productID' => create(Product::class)->productID,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product was added successfully']);
    }

    /** @test */
    public function guest_can_view_favourite(){
        $response = $this->getJson('/api/v1/favourite/retrieve',['favouriteIdentifier' => $this->favouriteIdentifier]);
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_can_delete_item_in_favourite(){
        $response = $this->getJson('/api/v1/favourite/delete/' . $this->favouriteDetails->favourites_detailID);
        $response->assertStatus(200)
            ->assertJson(['message' => 'the item was removed.']);
    }

    /** @test */
    public function guest_can_erase_favourite(){
        $response = $this->getJson('/api/v1/favourite/clear/' . $this->favouriteIdentifier);
        $response->assertStatus(200);
    }
    /** @test */
    public function guest_can_login_and_still_has_favourite(){
        $this->actingAs(create(User::class),'api');
        $this->getJson('/api/v1/favourite/updateowner/' . $this->favouriteIdentifier)
            ->assertStatus(200)
            ->assertJson(['message' => 'Owner was updated']);
    }
}
