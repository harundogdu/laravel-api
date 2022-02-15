<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
/**
 *@OA\Tag(
 *     name="Categories",
 *     description="Operations about categories",
 *     @OA\ExternalDocumentation(
 *     description="Find out more about our api",
 *     url="https://github.com/harundogdu",
 *     )
 *)
 */

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Get(
     *     path="/categories",
     *     summary="Get all categories",
     *     tags={"Categories"},
     *     operationId="index",
     *     @OA\Parameter (
     *     name="search",
     *     in="query",
     *     description="Search query",
     *     required=false,
     *      @OA\Schema(type="string",format="string")
     *     ),
     *     @OA\Parameter (
     *     name="limit",
     *     in="query",
     *     description="How many products to return",
     *     required=false,
     *     @OA\Schema(type="integer",format="int32")
     *     ),
     *     @OA\Parameter(
     *      name="offset",
     *      in="query",
     *      description="How many products to skip",
     *      required=false,
     *     @OA\Schema(type="integer",format="int32")
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Product"))
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
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->offset : 0;
        $limit = $request->has('limit') ? $request->limit : 10;

        $qb = Category::query()->with('products');
        if ($request->has('q'))
            $qb->where('name', 'like', '%' . $request->get('q') . '%');

        if ($request->has('sortBy'))
            $qb->orderBy($request->get('sortBy'), $request->get('sortOrder', 'desc'));

        $categories = $qb->offset($offset)->limit($limit)->get();

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Post (
     *     path="/categories",
     *     summary="Create a new category",
     *     tags={"Categories"},
     *     operationId="store",
     *     @OA\RequestBody(
     *        description="Product object that needs to be added to the store",
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Category")
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
    public function store(Request $request)
    {
        try {
            $category = new Category();

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->product_id = $request->product_id;
            $category->save();

            return response()->json($category, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * * @OA\Get(
     *     path="/categories/{categoryId}",
     *     summary="Get a category",
     *     tags={"Categories"},
     *     operationId="show",
     *     @OA\Parameter (
     *     name="categoryId",
     *     in="path",
     *     description="Category id",
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
            $product = Product::findOrFail($id);
            return response()->json($product, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     *  * @OA\Put  (
     *     path="/categories/{categoryId}",
     *     summary="Update a category",
     *     tags={"Categories"},
     *     operationId="update",
     *      @OA\Parameter (
     *     name="categoryId",
     *     in="path",
     *     description="Category id",
     *     required=true,
     *      @OA\Schema(type="integer",format="int16")
     *     ),
     *     @OA\RequestBody(
     *        description="Product object that needs to be added to the store",
     *        required=true,
     *        @OA\JsonContent(ref="#/components/schemas/Product")
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
            $category = Category::findOrFail($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);

            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * * @OA\Delete(
     *     path="/categories/{categoryId}",
     *     summary="Delete a category",
     *     tags={"Categories"},
     *     operationId="delete",
     *       @OA\Parameter (
     *     name="categoryId",
     *     in="path",
     *     description="Category id",
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
            $category = Category::findOrFail($id);
            $category->delete();
            return response()->json([
                'message' => "Category deleted successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function custom()
    {
        return Category::selectRaw('categories.name as name, count(*) as total')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->groupBy('name')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }
}
