<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a user listing.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Create a user.
     * 
     * @param  Request $request
     * @return App\User
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users,email',
            'given_name' => 'required',
            'family_name' => 'required',
        ]);

        return User::create($request->all());
    }
}
