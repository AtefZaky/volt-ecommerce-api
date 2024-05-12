<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()-> id();
        $user = User::find($user_id);
        $request ->validate([
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
            'image' => 'required',
        ]);

        UserContact::create([
            'user_id' => $user_id,
            'country' => $request -> country,
            'city' => $request -> city,
            'address' => $request -> address,
            'postal_code' => $request -> postal_code,
            'phone_number' => $request -> phone_number,
        ]);

        $user -> update([
            'image' => $request -> image,
            'has_contact' => 1
        ]);
        
        return response('contact added successfuly', 201);
    }

    public function storeImage(Request $request)
    {
        $user_id = auth()-> id();
        $request -> validate([
            'image' => 'required'
        ]);
        $pic = $request -> file('image') -> store('users', 'public');
        return response()->json(['image' => 'http://localhost:8000/storage/'.$pic]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $contact = $user->userContact()->first();
        return response() -> json(['contact',$contact]);
    }
}
