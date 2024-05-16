<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return the latest products 12 item per page and check if a filter is applied or not 

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

        // store the product image useing the local method
        $pic = $request -> file('image') -> store('products', 'public');
        // return the path to the image
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
}
