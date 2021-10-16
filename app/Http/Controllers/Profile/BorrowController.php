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
use Carbon\Carbon;

class BorrowController extends Controller
{

    public function index()
    {
        $borrows = Borrow::query()->where('id', auth()->id())->with('product')->get();
        return $this->success(BorrowResource::collection($borrows));
    }

    public function show(Borrow $borrow)
    {
        $borrow = $borrow->load('product');
        return $this->success(new BorrowResource($borrow));
    }

    public function store(BorrowStoreRequest $request)
    {
        if ($request->get('is_public') == 'yes' and Product::isAvailable($request->get('product_id'))) {
            $borrow = Borrow::query()->create([
                'user_id' => auth()->id(),
                'product_id' => $request->get('product_id'),
                'from_date' => Carbon::now(),
                'to_date' => $request->get('to_date'),
            ]);

            Product::query()->where('product_id', $request->get('product_id'))
                ->update([
                    'status_id' => Product::loaned,
            ]);


            Log::query()->create([
                'user_id' => auth()->id(),
                'action' => 'store',
                'description' => 'a borrow is stored'
            ]);

        } elseif (UserProduct::isAvailable(auth()->id(), $request->get('product_id'))) {

            $borrow = Borrow::query()->create([
                'user_id' => auth()->id(),
                'product_id' => $request->get('product_id'),
                'from_date' => Carbon::now(),
                'to_date' => $request->get('to_date'),
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
        if (!$borrow->supervisore_permission) {
            $borrow = $borrow->update([
                'user_id' => auth()->id(),
                'product_id' => $request->get('product_id'),
                'from_date' => Carbon::now(),
                'to_date' => $request->get('to_date'),
            ]);
            Log::query()->create([
                'user_id' => auth()->id(),
                'action' => 'update',
                'description' => 'a borrow is updated'
            ]);
            return $this->success(new BorrowResource($borrow));
        }

        return $this->error('You are not able to update');

    }

    public function destroy(Borrow $borrow)
    {

        if (!$borrow->supervisore_permission){
            $borrow->delete();
            Log::query()->create([
                'user_id' => auth()->id(),
                'action' => 'destroy',
                'description' => 'a borrow is deleted'
            ]);

            $borrow->product()->status_id = 1;

            return $this->success("borrow is deleted");
        }
        return $this->error('not able to delete');
    }

}
