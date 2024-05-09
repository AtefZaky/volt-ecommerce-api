<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->filter(request(['category', 'search', 'best_seller']))->paginate(12);
        return response() ->json(['products' => $products]);
    }
    /**
     * Display a specific listing of the resource.
     */
    public function show(Product $product)
    {
        $item = $product;
        return response() ->json(['product' => $item]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formField = $request ->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);

        $formFields['picture'] = $request->file('picture')->store('products', 'public');
        
        Product::create($formField);
        
        return response('product created successfuly', 201);
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
        $formFields= $request -> validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);

        $formFields['picture'] = $request->file('picture')->store('products', 'public');
        
        $product->update($formFields);
        
        return response('product updated successfuly', 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $product -> delete();
        return response('product deleted successfuly', 200);
    }
    /**
     *  add the product to the cart.
     */
    public function addToCart(Product $product, Request $request)
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $formField = $request ->validate([
            'quantity' => 'required'
        ]);
        for ($q = 0; $q < $request -> quantity ; $q++) {
            CartItem::create([
                'cart_id' => $user -> cart() -> first() -> id,
                'product_id' => $product -> id,
                'quantity' => 1,
            ]);
        }
        return response('item added succssfully', 201);
    }
    /**
     * 
     *  remove the product from the cart.
     */
    
    public function removeFromCart(Product $product, Request $request)
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $formField = $request ->validate([
            'quantity' => 'required'
        ]);
        for ($q = 0; $q < $request -> quantity ; $q++) {
            $cartItem = $user -> cart() -> first() -> cartItems() -> where('product_id', $product -> id) -> first();
            $cartItem -> delete();
        }
        return response($cartItem, 201);
    }

    // Reviews controllers

    public function indexReviews(Request $request)
    {
        $reviews = ProductReview::latest()->skip(0)->take(10)->get();
        return response() ->json(['reviews' => $reviews]);
    }

    public function showReviews(Product $product, Request $request)
    {
        $product_id = $product -> id;
        $reviews = ProductReview::latest()->where('product_id', $product_id)->get();
        return response() ->json(['reviews' => $reviews]);
    }

    public function storeReview(Product $product, Request $request)
    {
        $user_id = auth() -> id();
        $product_id = $product -> id;
        $request -> validate([
            'rating' => 'required',
            'comment' => 'required',
        ]);
        ProductReview::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
            'rating' => $request -> rating,
            'comment' => $request -> comment
        ]);
        return response('comment created successfuly', 201);
    }


}
