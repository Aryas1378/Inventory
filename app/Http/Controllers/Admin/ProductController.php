<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Log;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()->with('category', 'brand', 'status')->get();
        return $this->success(ProductResource::collection($products));
    }

    public function show(Product $product)
    {
        return $this->success(new ProductResource($product
            ->load('category', 'brand', 'status')));
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::query()->create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'status_id' => $request->get('status_id'),
            'is_public' => $request->get('is_public'),
        ]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'store',
            'description' => 'a product is stored'
        ]);

        return $this->success(new ProductResource($product));

    }

    public function update(ProductUpdateRequest $request, Product $product)
    {

        $product->update([
            'name' => $request->get('name'),
            'category_id' => $request->get('category_id'),
            'brand_id' => $request->get('brand_id'),
            'status_id' => $request->get('status_id'),
            'number' => $request->get('number'),
        ]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'a product is updated'
        ]);

        return $this->success(new ProductResource($product));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'destroy',
            'description' => 'a product is destroyed'
        ]);

        return $this->success("product is deleted");
    }

}
