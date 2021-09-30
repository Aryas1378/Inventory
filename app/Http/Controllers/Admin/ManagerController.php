<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManangerSubmitBorrowRequest;
use App\Http\Requests\TechnicalManagerSubmitBorrowRequest;
use App\Http\Resources\BorrowResource;
use App\Models\Borrow;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;

class ManagerController extends Controller
{
    use HasApiTokens;

    public function submitBorrow(ManangerSubmitBorrowRequest $request, Borrow $borrow)
    {
        if (is_null($borrow->manager_permission)){
            $borrow['manager_permission'] = $request->get('manager_permission');
            $borrow->save();
            return $this->success("permission was saved");
        }
        return $this->error("permission was submitted before by manager");
    }

    public function showBorrows(Product $product)
    {
        $borrows = Borrow::query()->where('product_id', $product->id)->get();
        return $this->success(BorrowResource::collection($borrows));
    }

}
