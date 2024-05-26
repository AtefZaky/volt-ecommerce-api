<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Reviews controllers

    public function index(Request $request)
    {
        // Get latest 10 reviews

        $reviews = ProductReview::latest()->skip(0)->take(10)->get();
        return response() ->json(['reviews' => $reviews]);
    }

    public function show(Product $product, Request $request)
    {
        // Get reviews in a product
    
        $product_id = $product -> id;
        $reviews = ProductReview::latest()->where('product_id', $product_id)->get();
        return response() ->json(['reviews' => $reviews]);
    }

    public function store(Product $product, Request $request)
    {
        // Add review to a product
        
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $product_id = $product -> id;
        $request -> validate([
            'rating' => 'required',
            'comment' => 'required',
        ]);
        ProductReview::create([
            'user_id' => $user_id,
            'customer_name' =>$user->name,
            'product_id' => $product_id,
            'rating' => $request -> rating,
            'comment' => $request -> comment
        ]);
        return response('comment created successfuly', 201);
    }
}
