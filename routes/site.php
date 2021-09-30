<?php

use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Profile\BorrowController;
use App\Http\Controllers\Profile\ProductController;
use App\Models\Borrow;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->middleware('auth:sanctum')->group(function () {


    Route::get('borrows', [BorrowController::class, 'index'])
        ->middleware('can:viewAny,' . Borrow::class)
        ->name('profile.borrows.index');

    Route::get('borrows/{borrow}', [BorrowController::class, 'show'])
        ->middleware('can:view,borrow')
        ->name('profile.borrows.index');

    Route::post('products/{product}/borrows', [BorrowController::class, 'store'])
        ->middleware('can:create,' . Borrow::class)
        ->name('profile.borrows.store');

    Route::patch('borrows/{borrow}', [BorrowController::class, 'update'])
        ->middleware('can:update,borrow')
        ->name('profile.borrows.update');

    Route::delete('borrows/{borrow}', [BorrowController::class, 'destroy'])
        ->middleware('can:delete,borrow')
        ->name('profile.borrows.destroy');

    Route::get('profile-products', [ProductController::class, 'index'])
        ->middleware('can:viewAny,' . Product::class)
        ->name('profile.profile-products.index');

    Route::get('profile-products/{userProduct}', [ProductController::class, 'show'])
        ->middleware('can:view,userProduct')
        ->name('profile.profile-products.show');

    Route::post('submit/profile-products/{userProduct}', [ProductController::class, 'submit'])
        ->middleware('can:update,userProduct')
        ->name('profile.profile-products.update');

    Route::patch('change-password/user/{user}', [PasswordController::class, 'changePassword'])
        ->middleware('can:update,user')
        ->name('profile.change-password.update');

});
