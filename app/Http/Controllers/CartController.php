<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Get cart Items for authenticated user

    public function index()
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $cart = $user -> cart() -> first() -> cartItems() -> get();
        // Get the total price
        $total_price = 0;
        foreach($cart as $i){
            $price = Product::where('id', $i -> product_id)->first()->price;
            $total_price = $total_price + $price * $i->quantity;
        }
        return response()->json(['cart'=> $cart , 'total' => $total_price]);
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

        // Get the user cart
        $cart = $user -> cart() -> first();
        // Check if the cart is not empty
        if ($cart->cartItems()->get() != []){
            // Check if the item in the cart
            foreach($cart->cartItems()->get() as $i){
                // if the item in the cart increase its quantity
                if ($i -> product_id == $product->id){
                    $i -> update([
                        'cart_id' => $i->cart_id,
                        'product_id' => $i->product_id,
                        'quantity' => $i->quantity + request()->quantity,
                    ]);
                    return response('Item added succssfully', 201);
                }
            }
        }

        // if the item not in the cart or the cart is empty
        CartItem::create([
            'cart_id' => $user -> cart() -> first() -> id,
            'product_id' => $product -> id,
            'quantity' => request()->quantity,
        ]);

        return response('Item added succssfully', 201);
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
         // Get user cart items
         $cart = $user -> cart() -> first();
         foreach($cart->cartItems()->get() as $i){
             if ($i -> product_id == $product->id){
                // check if you need to remove all the items
                if ($i-> quantity == request()->quantity){
                    $i -> delete();
                }
                // else update the quantity
                $i -> update([
                    'cart_id' => $i->cart_id,
                    'product_id' => $i->product_id,
                    'quantity' => $i->quantity - request()->quantity,
                ]);
             }
         }
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
        return response('item removed succssfully', 201);
    }
}
