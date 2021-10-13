<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsStoreRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\Log;

class BrandsController extends Controller
{

    public function index()
    {
        $brands = Brand::all();
        return $this->success(BrandResource::collection($brands));
    }

    public function show(Brand $brand)
    {
        return $this->success(new BrandResource($brand));
    }

    public function store(BrandsStoreRequest $request)
    {
        $brand = Brand::query()->create(
            ['name' => $request->get('name')]
        );

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'store',
            'description' => 'a brand is stored'
        ]);

        return $this->success(new BrandResource($brand));
    }

    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $brand->update(['name' => $request->get('name')]);

        Brand::create($request->all());

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'a brand is updated'
        ]);

        return $this->success(new BrandResource($brand));
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->count()) {
            return $this->error("this brand has some products");
        }

        $brand->delete();

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'destroy',
            'description' => 'a brand is destroyed'
        ]);

        return $this->success("brand is deleted");

    }

}
