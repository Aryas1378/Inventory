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

    public function allBorrows()
    {
        $borrows = Borrow::all();
        return $this->success(BorrowResource::collection($borrows));
    }

    public function showBorrow(Borrow $borrow)
    {
        return $this->success(new BorrowResource($borrow->load('product')));
    }

    public function submitBorrow(ManangerSubmitBorrowRequest $request, Borrow $borrow)
    {
        if (is_null($borrow->manager_permission) and $borrow->technical_manager_permission){
            $borrow['manager_permission'] = $request->get('manager_permission');
            $borrow->save();
            return $this->success("permission was saved");
        }
        return $this->error("This action is not valid");
    }

}
