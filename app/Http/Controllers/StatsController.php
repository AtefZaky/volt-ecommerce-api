<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class StatsController extends Controller
{
    
    public function index()
    {
        // Get the sum of all deliverd products
        $revenue = Order::all()->where('status', 'deliverd')->sum('total_price');
        $cancel = Order::all()->where('status', 'canceld')->sum('total_price');
        // Get total pennding and delivered orders
        $all = Order::all()->sum('total_price');
        $total = $all - $cancel;
        // Get the number of users
        $users = User::all()->count();
        return response()->json([['total revenue', $revenue.' LE'], ['total orders', $total.' LE'], ['number of users', $users]]);
    }
}