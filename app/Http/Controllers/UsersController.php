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
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     operationId="index",
     *     @OA\Response(response="200", description="Users index.")
     * )
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
     * @OA\Post(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Add a new user.",
     *     operationId="create",
     *     @OA\Response(
     *         response="default",
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation exception",
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     )
     * )
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

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Display a user.
     *
     * @OA\Get(
     *   path="/users/{id}",
     *   tags={"Users"},
     *   summary="Get user by id.",
     *   operationId="show",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="The id of the user that needs to be fetched.",
     *     required=true,
     *     @OA\Schema(
     *         type="string"
     *     )
     *   ),
     *   @OA\Response(
 *         response="default",
 *         description="Successful operation"
     *   )
     * )
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
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     operationId="update",
     *     summary="Update an existing user.",
     *     description="",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of the user that needs to be fetched.",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *       )
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation exception",
     *     )
     * )
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
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Deletes a user",
     *     description="",
     *     operationId="destroy",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         description="User id to delete.",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
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
