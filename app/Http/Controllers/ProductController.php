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
        $products = Product::latest()->filter(request(['category_id', 'search', 'best_seller']))->paginate(12);
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
            'picture' => 'required',
        ]);
        
        
        Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'picture' => $request->picture,
        ]);
        
        return response('product created succssfully', 201);
    }

    public function storeImage(Request $request){
        $request -> validate([
            'image' => 'required'
        ]);
        $pic = $request -> file('image') -> store('products', 'public');
        return response()->json(['image' => 'http://localhost:8000/storage/'.$pic]);
    }
    
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $formFields= $request -> validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'picture' => 'required'
        ]);
        
        $product->update($formFields);
        
        return response('product updated successfuly', 201);
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
        $cart = $user -> cart() -> first();
        if ($cart->cartItems()->get() == []){
            foreach($cart->cartItems()->get() as $i){
                if ($i -> product_id == $product->id){
                    $i -> update([
                        'cart_id' => $i->cart_id,
                        'product_id' => $i->product_id,
                        'quantity' => $i->quantity + request()->quantity,
                    ]);
                }
            }
        } else{
            CartItem::create([
                'cart_id' => $user -> cart() -> first() -> id,
                'product_id' => $product -> id,
                'quantity' => request()->quantity,
            ]);
        }
        return response('Item added succssfully', 201);
        // for ($q = 0; $q < $request -> quantity ; $q++) {
        //     CartItem::create([
        //         'cart_id' => $user -> cart() -> first() -> id,
        //         'product_id' => $product -> id,
        //         'quantity' => 1,
        //     ]);
        // }
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
        $cart = $user -> cart() -> first();
        foreach($cart->cartItems()->get() as $i){
            if ($i -> product_id == $product->id){
                if ($i-> quantity == request()->quantity){
                    $i -> delete();
                }
                $i -> update([
                    'cart_id' => $i->cart_id,
                    'product_id' => $i->product_id,
                    'quantity' => $i->quantity - request()->quantity,
                ]);
            }
        }
        // for ($q = 0; $q < $request -> quantity ; $q++) {
        //     $cartItem = $user -> cart() -> first() -> cartItems() -> where('product_id', $product -> id) -> first();
        //     $cartItem -> delete();
        // }
        return response('item removed succssfully', 201);
    }
    public function deleteFromCart(Product $product, Request $request)
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $formField = $request ->validate([
            'quantity' => 'required'
        ]);
        $cart = $user -> cart() -> first();
        foreach($cart->cartItems()->get() as $i){
            if ($i -> product_id == $product->id){
                $i -> delete();
            }
        }
        // for ($q = 0; $q < $request -> quantity ; $q++) {
        //     $cartItem = $user -> cart() -> first() -> cartItems() -> where('product_id', $product -> id) -> first();
        //     $cartItem -> delete();
        // }
        return response('item removed succssfully', 201);
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
