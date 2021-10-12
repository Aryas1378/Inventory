<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProductStoreRequest;
use App\Http\Requests\UserProductUpdateRequest;
use App\Http\Resources\UserProductResource;
use App\Models\Product;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Log;

class UserProductController extends Controller
{

    public function index()
    {
        $users_products = UserProduct::query()->with('status', 'user', 'product')->get();

        return $this->success(UserProductResource::collection($users_products));

    }

    public function show(UserProduct $userProduct)
    {
        return $this->success(new UserProductResource($userProduct
            ->load('status', 'user', 'product')));
    }

    public function store(UserProductStoreRequest $request)
    {

        /** @var UserProduct $user_product */
        $user_product = UserProduct::query()->create([
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
            'code' => $request->get('code'),
            'from_date' => $request->get('from_date'),
        ]);

        $product = Product::query()->where('id', $request->get('product_id'))->get();
        $product['status_id'] = Product::loaned;

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'store',
            'description' => 'a userProduct is stored'
        ]);

        return $this->success(new UserProductResource($user_product->load('user')));
    }

    public function update(UserProductUpdateRequest $request, UserProduct $userProduct)
    {
        $userProduct->update([
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
            'code' => $request->get('code'),
            'from_date' => $request->get('from_date'),
            'status_id' => $request->get('status_id'),
        ]);

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'update',
            'description' => 'a userProduct is updated'
        ]);

        return $this->success(new UserProductResource($userProduct));
    }

    public function destroy(UserProduct $userProduct)
    {

        $userProduct->delete();
        $product = Product::query()->where('id', $userProduct['product_id'])->get();
        $product['status_id'] = Product::available;

        Log::query()->create([
            'user_id' => auth()->user(),
            'action' => 'destroy',
            'description' => 'a userProduct is destroyed'
        ]);

        return $this->success("userProduct is deleted");
    }

}
