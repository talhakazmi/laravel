<?php

namespace App\Http\Controllers\StoreControllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $product
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        $reviews = Review::sortable()->whereProduct($product)->latest()->paginate(10);

        return response($reviews);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @param \App\Review $review
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Review $review)
    {
        return response($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @param \App\Review $review
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $review->delete();

        return response(['success' => 'Review was deleted successfully']);
    }
}
