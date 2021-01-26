<?php

namespace App\Jobs;

use App\flavor;
use App\productColors;
use App\Productimages;
use App\productOptions;
use App\products;
use App\productSizes;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Redirect;

class AdminStoreProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = products::StoreProducts(request()->all());
        Productimages::Images($products, request()->input('ImageLink'));
        productSizes::Store(request()->all(), $products->productID);
        productColors::Store(request()->all(), $products->productID);
        flavor::store(request()->all(), $products->productID);

        if (request()->productsHasOptions !=  null){
            if (request()->optionsHasDifferentPrices != null)
            {
                productOptions::store($products->productID);
            }else{
                productOptions::storeIfOptionButSamePrice($products->productID);

            }
        }else{
            productOptions::storeIfNoOptions($products->productID);

        }

        return $products;
    }
}
