<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    /**
     * Display a user.
     * 
     * @param  int $id
     * @return App\User
     */
    public function show($id)
    {
        $user = User::find($id);

        return $user !== null ? $user : response()->json(['Error' => 'Not Found'], 404);
    }

    /**
     * Update a user.
     * 
     * @param  Request $request
     * @param  int  $id
     * @return App\User
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => ['required', Rule::unique('users')->ignore($id)],
            'given_name' => 'required',
            'family_name' => 'required',
        ]);

        $user = User::find($id);

        if($user === null)
            return response()->json(['Error' => 'Not Found'], 400);

        $user->fill($request->all());
        $user->save();

        return $user;
    }

    /**
     * Delete a user.
     * 
     * @param  int $id
     * @return Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user === null)
            return response()->json(['Error' => 'Not Found'], 400);

        $user->delete();

        return response()->json(null, 204);
    }
}
