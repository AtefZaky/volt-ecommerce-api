<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserContactController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()-> user();
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
    public function index()
    {
        $user_id = auth()-> user();
        $contact = DB::table('user_contacts')->where('user_id', $user_id)->first();
        return response() -> json(['contact' => $contact]);
    }
}
