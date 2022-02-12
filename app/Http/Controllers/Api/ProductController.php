<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //return response()->json(Product::all(), 200);
        //return response()->json(Product::paginate(10), 200);
        //return response()->json(['count' => Product::count()], 200);

        $offset = $request->has('offset') ? $request->offset : 0;
        $limit = $request->has('limit') ? $request->limit : 10;

        $qb = Product::query()->with('category');
        if ($request->has('q')) {
            $qb->where('name', 'like', '%' . $request->q . '%');
        }
        if ($request->has('sort')) {
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'desc'));
        }

        $products = $qb->offset($offset)->limit($limit)->get();

        $products = $products->makeHidden(['created_at', 'updated_at']);

        return $this->apiResponse(ResultType::SUCCESS, $products, 'Products fetched successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->description = $request->description;
            $product->price = $request->price;
            $product->amount = $request->amount;
            $product->image = $request->image;
            $product->category_id = mt_rand(1, 30);
            $product->save();

            return $this->apiResponse(ResultType::SUCCESS, $product, "Product was created successfully", 201);
        } catch (\Exception $exception) {
            return $this->apiResponse(ResultType::SUCCESS, null, $exception->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product)
            return $this->apiResponse(ResultType::SUCCESS, new ProductResource($product), "Product was fetched successfully", 200);
        else
            return $this->apiResponse(ResultType::SUCCESS, null, "Product not found", 404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->description = $request->description;
            $product->price = $request->price;
            $product->amount = $request->amount;
            $product->image = $request->image;
            $product->category_id = $request->category_id;
            $product->save();
            return $this->apiResponse(ResultType::SUCCESS, $product, "Product was updated successfully", 200);
        } else {
            return $this->apiResponse(ResultType::SUCCESS, null, "Product not found", 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return $this->apiResponse(ResultType::SUCCESS, null, "Product was deleted successfully", 200);
        } else
            return $this->apiResponse(ResultType::SUCCESS, null, "Product not found", 404);
    }

    public function custom()
    {
        // return Product::pluck('id', 'name'); Tekli Kolon Çekmek İçin
        //return Product::select('id', 'name', 'price')->orderBy('price','DESC')->take(10)->get(); // Birden Fazla Kolon Çekmek İçin
        return Product::selectRaw('id as product_id, name as product_name, price as product_price')->orderBy('price', 'DESC')->take(10)->get(); // Kolanlara takma isim vermek için
    }

    public
    function custom2()
    {
        $products = Product::orderBy('price', 'DESC')->take(10)->get();

        $mapped = $products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price
            ];
        });

        return $mapped->all();
    }

    public
    function custom3()
    {
        $products = Product::all();
        ProductResource::withoutWrapping(); // Resource içinde data olarak dönmemesi için
        return ProductResource::collection($products);
    }

    public
    function listWithCategories()
    {
        $products = Product::with('category')->paginate(10);
        return ProductWithCategoriesResource::collection($products);
    }
}
