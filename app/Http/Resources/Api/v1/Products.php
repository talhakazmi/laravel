<?php

namespace App\Http\Resources\Api\v1;

use App\Option;
use App\ProductOptions;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use App\Http\Resources\Api\v1\Categories as CategoryResource;
use App\Http\Resources\Api\v1\SubCategory as SubCategoryResource;
use App\Http\Resources\Api\v1\Brands as BrandResource;
use App\Http\Resources\Api\v1\Specialties as SpecialtyResource;
use App\Http\Resources\Api\v1\Shops as ShopResource;
class Products extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'productID' => $this->productID,
            'productName' => $this->name,
            'description' => $this->description,
            'content' => $this->content,
            'main_image' => $this->mainImage,
            'shop' => new ShopResource($this->Shop),
            'brand' => new BrandResource($this->Brands),
            'specialty' => new SpecialtyResource($this->Speciality),
            'options' => $this->handleOptions(),
	        'reviews' => $this->Reviews,
            'promoted' => $this->promoted,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'discount' => floor(abs(((($this->price - $this->promoted)/$this->price)*100))). "%",
            'thumbnail_images' => $this->MainImages,
            'primary_images' => $this->OtherImages,
            'added_to_Cart' => $this->added_to_cart,
            'added_to_favourite' => $this->added_to_favourite,
            'meta' => $this->meta
        ];
    }

    private function handleOptions()
    {
        $productOption = Option::all();
        foreach ( $productOption as $option) {
            $option['values'] = ProductOptions::where('products_productID',$this->productID)->where('options_optionID',$option->optionID)->get();
        }
        return $productOption;
    }
}
