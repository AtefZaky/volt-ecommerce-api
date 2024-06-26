<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get latest product 8 in each page

        $orders = Order::latest()->paginate(8);
        return response()->json([['orders', $orders]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth() -> id();
        $user = User::find($user_id);

        // Get the user Cart items
        $items = $user ->cart()->first()->cartItems()->get();

        // Get the total price of the order
        $total_price = 0;
        foreach($items as $i){
            $price = Product::where('id', $i -> product_id)->first()->price;
            $total_price = $total_price + $price * $i->quantity;
        }

        // Create the order
        $order = Order::create([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'status' => 'pending'
        ]);

        // Add orders lines and delete them form the cart
        foreach ($user->cart()->first()->cartItems()->get() as $i) {
            OrderLine::create([
                'order_id' => $order -> id,
                'product_id' => $i -> product_id,
                'quantity' => $i -> quantity
            ]);
            $i -> delete();
        }
        return response('order made succssfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Return user order data and contact info

        $data = [['order', $order] , ['user',$order->user()->first()],['user_contacts',$order->user()->first()->userContact()->first()]];
        return response() -> json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $orderr = $order->update([
            'user_id' => $order ->user_id,
            'total_price' => $order ->total_price,
            'status' => $request ->status
        ]);
        return response('order updated succssufuly', 201);
    }
}
