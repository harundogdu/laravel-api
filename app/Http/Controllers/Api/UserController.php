<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * * @OA\Tag(
 *     name="Users",
 *     description="Operations about users",
 *     @OA\ExternalDocumentation(
 *     description="Find out more about our api",
 *     url="https://github.com/harundogdu",
 *     )
 *)
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     *     * @OA\Get(
     *     path="/users",
     *     summary="Get all users",
     *     tags={"Users"},
     *     operationId="index",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *      ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *           @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *      ),
     *     @OA\Response(
     *      response=401,
     *      description="Unauthenticated",
     *              @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *      ),
     *     @OA\Response(
     *      response=403,
     *      description="Forbidden",
     *              @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Resource Not Found",
     *          @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *      ),
     *     @OA\Response (
     *      response="default",
     *      description="unexpected error",
     *       @OA\JsonContent(type="object", @OA\Property(property="message", type="string"))
     *      ),
     *      security={{"api_token": {}},{"bearer_token": {}}}
     *
     * )
     */
    public function index()
    {
        $users = User::all();
        $users->each->setAppends(['full_name']);
        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     *  @OA\Post (
     *     path="/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     operationId="store",
     *     @OA\RequestBody(
     *        description="Product object that needs to be added to the store",
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *     response=404,
     *     description="Resource Not Found",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     security={{"api_token": {}},{"bearer_token": {}}}
     *)
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->save();
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Get(
     *     path="/users/{userId}",
     *     summary="Get a user",
     *     tags={"Users"},
     *     operationId="show",
     *     @OA\Parameter (
     *     name="userId",
     *     in="path",
     *     description="User id",
     *     required=true,
     *      @OA\Schema(type="integer",format="int16")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *     response=404,
     *     description="Resource Not Found",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     security={{"api_token": {}},{"bearer_token": {}}}
     *)
     */
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Put  (
     *     path="/users/{usersId}",
     *     summary="Update a users",
     *     tags={"Users"},
     *     operationId="update",
     *      @OA\Parameter (
     *     name="usersId",
     *     in="path",
     *     description="User id",
     *     required=true,
     *      @OA\Schema(type="integer",format="int16")
     *     ),
     *     @OA\RequestBody(
     *        description="Product object that needs to be added to the store",
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/User")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *     response=404,
     *     description="Resource Not Found",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *      response=500,
     *      description="Internal Server Error",
     *      @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     security={{"api_token": {}},{"bearer_token": {}}}
     *)
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->email = $request->email;
            $user->save();
            return response()->json([
                'message' => 'User updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Delete(
     *     path="/users/{userId}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     operationId="delete",
     *       @OA\Parameter (
     *     name="userId",
     *     in="path",
     *     description="Product id",
     *     required=true,
     *      @OA\Schema(type="integer",format="int16")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *           @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *     response=404,
     *     description="Resource Not Found",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     @OA\Response(
     *      response=500,
     *      description="Internal Server Error",
     *      @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ApiResponse"))
     *      ),
     *     security={{"api_token": {}},{"bearer_token": {}}}
     *  )
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => "User deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function custom()
    {
        /*
         * $user = User::find(2);
         * return new UserResource($user);
         * {
         *  "data": {
         *      "id": 2,
         *      "name": "Mariam Fritsch",
         *      "first_name": "Jailyn",
         *      "last_name": "Koelpin"
         *    }
         * }
         */

        //        $user = User::all();
        //        return UserResource::collection($user);

//        $users = User::all();
//        return new UserCollection($users);
        //  UserCollection dosyasını oluşturarak dönen veriyi düzenleyebiliriz.

        $users = User::all();
        return UserResource::collection($users)->additional([
            'meta' => [
                "total" => $users->count(),
            ]
        ]);
    }
}
