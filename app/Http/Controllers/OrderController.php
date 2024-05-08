<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return response()->json([['orders', $orders]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth() -> user();
        $user = DB::table('user')->where('user_id', $user_id)->first();
        $total_price = $user ->cart()->cartItems()->sum('price');
        $order = Order::create([
            'user_id' => $user_id,
            'total_price' => $total_price,
        ]);
        foreach ($user->cart()->cartItems() as $i) {
            OrderLine::create([
               'order_id' => $order -> id,
               'product_id' => $i -> product_id,
               'price' => $i -> price
            ]);
            $i -> delete();
        }
        return response('order created succssufuly', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $data = [['order', $order], ['user',$order->user()], ['user_contacts',$order->user()->userContact()]];
        return response() -> json($data, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
