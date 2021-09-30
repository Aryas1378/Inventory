<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Log;


class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return $this->success(CategoryResource::collection($categories));
    }

    public function show(Category $category)
    {
        return $this->success(new CategoryResource($category));
    }

    public function store(CategoryStoreRequest $request)
    {

        $category = Category::query()->create(['name' => $request->get('name')]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'store',
            'description' => 'a category is stored'
        ]);

        return $this->success(new CategoryResource($category));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update(['name' => $request->get('name')]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'a category is updated'
        ]);

        return $this->success(new CategoryResource($category));
    }

    public function destroy(Category $category)
    {

        if ($category->products()->count())
        {
            return $this->error("This Category is used by some products");
        }

        $category->delete();

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'destroy',
            'description' => 'a category is destroyed'
        ]);

        return $this->success("category is deleted");

    }

}
