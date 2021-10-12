<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserProductSubmitRequest;
use App\Http\Resources\ProfileProductResource;
use App\Models\UserProduct;

class ProductController extends Controller
{
    public function index()
    {
        $products = UserProduct::query()
            ->where('user_id', auth()->id())
            ->with('status', 'product', 'product.category', 'product.brand')
            ->get()
            /*->simplePaginate(1)*/;
        return $this->success(ProfileProductResource::collection($products));
    }

    public function show(UserProduct $userProduct)
    {
        return $this->success(new ProfileProductResource($userProduct
            ->load('status', 'product', 'product.category', 'product.brand')
        ));
    }

    public function submit(UserProductSubmitRequest $request, UserProduct $userProduct)
    {
        if (is_null($userProduct->submit))
        {
            $userProduct['submit'] = $request->get('submit');
            $userProduct->save();
            return $this->success(new ProfileProductResource($userProduct
                ->load('status', 'product', 'product.category', 'product.brand')
            ));
        }
        return $this->error("submit column of this product was saved before");
    }

}
