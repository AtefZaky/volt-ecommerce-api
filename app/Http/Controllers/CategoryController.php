<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response() ->json(['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formField = $request ->validate([
            'name' => 'required'
        ]);
        
        Category::create($formField);

        return response('category created successfuly', 201);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $formFields= $request -> validate([
            'name' => 'required'
        ]);

        $category->update($formFields);

        return response('category updated successfuly', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category -> delete();
        return response('category deleted successfuly', 200);
    }
}
