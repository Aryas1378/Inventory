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

    public function allBorrows()
    {
        $borrows = Borrow::all();
        return $this->success(BorrowResource::collection($borrows));
    }

    public function submitBorrow(TechnicalManagerSubmitBorrowRequest $request, Borrow $borrow)
    {
        if (is_null($borrow->technical_manager_permission) and $borrow->supervisor_permission){
            $borrow['technical_manager_permission'] = $request->get('technical_manager_permission');
            $borrow->save();
            return $this->success("permission was saved");
        }
        return $this->error("This action is not valid");
    }

    public function showBorrow(Borrow $borrow)
    {
        return $this->success(new BorrowResource($borrow->load('product')));
    }

}
