<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ManangerSubmitBorrowRequest;
use App\Http\Requests\TechnicalManagerSubmitBorrowRequest;
use App\Models\Borrow;
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

}