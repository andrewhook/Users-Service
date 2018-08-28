<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a user listing.
     * 
     * @return [type] [description]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * 
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'given_name' => 'required',
            'family_name' => 'required',
        ]);

        return User::create($request->all());
    }
}
