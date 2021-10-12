<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request, User $user)
    {
        if (Hash::check($request->get('old_password'),$user['password'])){
            $user['password'] = bcrypt($request->get('new_password'));
            $user->save();
            return $this->success("Password was saved successfully");
        }
        return $this->error("Your current password is not correct");
    }

}
