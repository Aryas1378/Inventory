<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowStoreRequest;
use App\Http\Requests\BorrowUpdateRequest;
use App\Http\Resources\BorrowResource;
use App\Models\Borrow;
use App\Models\Log;
use App\Models\Product;
use App\Models\UserProduct;

class BorrowController extends Controller
{

    public function index()
    {
        $borrows = Borrow::query()->with('product', 'user')->get();
        return $this->success(BorrowResource::collection($borrows));
    }

    public function show(Borrow $borrow)
    {
        $borrow = $borrow->load('product', 'user');
        return $this->success(new BorrowResource($borrow));
    }

    public function store(BorrowStoreRequest $request, Product $product)
    {

        if ($request->get('is_public') == 'yes' and $product->status_id == Product::available) {
            $borrow = Borrow::query()->create([
                'user_id' => $request->get('user_id'),
                'product_id' => $product->id,
                'from_date' => $request->get('from_date'),
                'to_date' => $request->get('to_date'),
                'supervisor_permission' => $request->get('supervisor_permission'),
            ]);

            $product->update(array('status_id' => Product::loaned));

            Log::query()->create([
                'user_id' => auth()->id(),
                'action' => 'store',
                'description' => 'a borrow is stored'
            ]);

        } elseif (UserProduct::query()->where(['user_id' => auth()->id()], ['product_id' => $product->id])->count()) {
            $borrow = Borrow::query()->create([
                'user_id' => $request->get('user_id'),
                'product_id' => $request->get('product_id'),
                'from_date' => $request->get('from_date'),
                'to_date' => $request->get('to_date'),
                'supervisor_permission' => $request->get('supervisor_permission'),
            ]);
            Log::query()->create([
                'user_id' => auth()->id(),
                'action' => 'store',
                'description' => 'a borrow is stored'
            ]);

        } else {
            return $this->error("This product is not available for you");
        }

        return $this->success($borrow);
    }

    public function update(BorrowUpdateRequest $request, Borrow $borrow)
    {
        $borrow = $borrow->update([
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'supervisor_permission' => $request->get('supervisor_permission'),
        ]);

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'update',
            'description' => 'a borrow is updated'
        ]);

        return $this->success(new BorrowResource($borrow));
    }

    public function destroy(Borrow $borrow)
    {
        $borrow->delete();

        Log::query()->create([
            'user_id' => auth()->id(),
            'action' => 'destroy',
            'description' => 'a borrow is deleted'
        ]);

        $borrow->product()->status_id = 1;

        return $this->success("borrow is deleted");
    }

}
