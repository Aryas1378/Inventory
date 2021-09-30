<?php

use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TechnicalManagerController;
use App\Http\Controllers\Admin\UserProductController;
use App\Models\Borrow;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\Status;
use App\Models\TechnicalManager;
use App\Models\UserProduct;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware('auth:sanctum')->group(function () {

    Route::get('categories', [CategoryController::class, 'index'])
        ->middleware('can:viewAny,' . Category::class)
        ->name('admin.categories.index');

    Route::get('categories/{category}', [CategoryController::class, 'show'])
        ->middleware('can:view,category')
        ->name('admin.categories.show');

    Route::post('categories', [CategoryController::class, 'store'])
        ->middleware('can:create,' . Category::class)
        ->name('admin.categories.store');

    Route::patch('categories/{category}', [CategoryController::class, 'update'])
        ->middleware('can:update,category')
        ->name('admin.categories.update');

    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])
        ->middleware('can:delete,category')
        ->name('admin.categories.destroy');

    Route::get('brands', [BrandsController::class, 'index'])
        ->middleware('can:viewAny,' . Brand::class)
        ->name('admin.brands.index');

    Route::get('brands/{brand}', [BrandsController::class, 'show'])
        ->middleware('can:view,brand')
        ->name('admin.brands.show');

    Route::post('brands', [BrandsController::class, 'store'])
        ->middleware('can:create,' . Brand::class)
        ->name('admin.brands.store');

    Route::patch('brands/{brand}', [BrandsController::class, 'update'])
        ->middleware('can:update,brand')
        ->name('admin.brands.update');

    Route::delete('brands/{brand}', [BrandsController::class, 'destroy'])
        ->middleware('can:delete,brand')
        ->name('admin.brands.destroy');

    Route::get('statuses', [StatusController::class, 'index'])
        ->middleware('can:viewAny,' . Status::class)
        ->name('admin.statuses.index');

    Route::get('statuses/{status}', [StatusController::class, 'show'])
        ->middleware('can:view,status')
        ->name('admin.statuses.show');

    Route::post('statuses', [StatusController::class, 'store'])
        ->middleware('can:create,' . Status::class)
        ->name('admin.statuses.store');

    Route::patch('statuses/{status}', [StatusController::class, 'update'])
        ->middleware('can:update,status')
        ->name('admin.statuses.update');

    Route::delete('statuses/{status}', [StatusController::class, 'destroy'])
        ->middleware('can:delete,status')
        ->name('admin.statuses.destroy');

    Route::get('products', [ProductController::class, 'index'])
        ->middleware('can:viewAny,' . Product::class)
        ->name('admin.products.index');

    Route::get('products/{product}', [ProductController::class, 'show'])
        ->middleware('can:view,product')
        ->name('admin.products.show');

    Route::post('products', [ProductController::class, 'store'])
        ->middleware('can:create,' . Product::class)
        ->name('admin.products.store');

    Route::patch('products/{product}', [ProductController::class, 'update'])
        ->middleware('can:update,product')
        ->name('admin.products.update');

    Route::delete('products/{product}', [ProductController::class, 'destroy'])
        ->middleware('can:delete,product')
        ->name('admin.products.destroy');

    Route::get('roles', [RoleController::class, 'index'])
        ->middleware('can:viewAny,' . Role::class)
        ->name('admin.roles.index');

    Route::get('roles/{role}', [RoleController::class, 'show'])
        ->middleware('can:view,role')
        ->name('admin.roles.show');

    Route::post('roles', [RoleController::class, 'store'])
        ->middleware('can:create,' . Role::class)
        ->name('admin.roles.store');

    Route::patch('roles/{role}', [RoleController::class, 'update'])
        ->middleware('can:update,role')
        ->name('admin.roles.update');

    Route::delete('roles/{role}', [RoleController::class, 'destroy'])
        ->middleware('can:delete,role')
        ->name('admin.roles.destroy');

    Route::get('user-product', [UserProductController::class, 'index'])
        ->middleware('can:viewAny,' . UserProduct::class)
        ->name('admin.user-product.index');

    Route::get('user-product/{userProduct}', [UserProductController::class, 'show'])
        ->middleware('can:view,userProduct')
        ->name('admin.user-product.show');

    Route::post('user-product', [UserProductController::class, 'store'])
        ->middleware('can:create,' . UserProduct::class)
        ->name('admin.user-product.store');

    Route::patch('user-product/userProduct', [UserProductController::class, 'update'])
        ->middleware('can:update,userProduct')
        ->name('admin.user-product.update');

    Route::delete('user-product/userProduct', [UserProductController::class, 'destroy'])
        ->middleware('can:delete,userProduct')
        ->name('admin.user-product.delete');

    Route::patch('technical-manager/submit/borrows/{borrow}', [TechnicalManagerController::class, 'submitBorrow'])
        ->middleware('can:update,borrow')
        ->name('admin.technical-manager.submitBorrow');

    Route::patch('manager/submit/borrows/{borrow}', [ManagerController::class, 'submitBorrow'])
        ->middleware('can:update,borrow')
        ->name('admin.technical-manager.submitBorrow');

    Route::get('manager/products/{product}/borrows', [ManagerController::class, 'showBorrows'])
        ->middleware('can:viewAny,' . Borrow::class)
        ->name('manager.products-borrows.index');

    Route::get('technical-manager/products/{product}/borrows', [TechnicalManagerController::class, 'showBorrows'])
        ->middleware('can:viewAny,' . Borrow::class)
        ->name('manager.products-borrows.index');

});
