<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicalManagerSubmitBorrowRequest;
use App\Http\Resources\BorrowResource;
use App\Models\Borrow;
use App\Models\Product;
use Laravel\Sanctum\HasApiTokens;

class TechnicalManagerController extends Controller
{
    use HasApiTokens;

    public function submitBorrow(TechnicalManagerSubmitBorrowRequest $request, Borrow $borrow)
    {
        if (is_null($borrow->technical_manager_permission)){
            $borrow['technical_manager_permission'] = $request->get('technical_manager_permission');
            $borrow->save();
            return $this->success("permission was saved");
        }
        return $this->error("permission was submitted before by technical manager");
    }

    public function showBorrows(Product $product)
    {
        $borrows = Borrow::query()->where('product_id', $product->id)->get();
        return $this->success(BorrowResource::collection($borrows));
    }

}
