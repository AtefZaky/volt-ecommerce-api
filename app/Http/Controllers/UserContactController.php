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
        $request ->validate([
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required',
            'phone_number' => 'required',
        ]);

        UserContact::create([
            'user_id' => $user_id,
            'country' => $request -> country,
            'city' => $request -> city,
            'address' => $request -> address,
            'postal_code' => $request -> postal_code,
            'phone_number' => $request -> phone_number,
        ]);
        
        return response('contact added successfuly', 201);
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
