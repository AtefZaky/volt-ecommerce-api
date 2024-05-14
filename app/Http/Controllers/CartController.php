<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function index()
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);
        $cart = $user -> cart() -> first() -> cartItems() -> get();
        $total_price = 0;
        foreach($cart as $i){
            $price = Product::where('id', $i -> product_id)->first()->price;
            $total_price = $total_price + $price * $i->quantity;
        }
        return response()->json(['cart'=> $cart , 'total' => $total_price]);
    }
}
