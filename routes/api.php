<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

include 'admin.php';
include 'site.php';

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/user/authenticate', [AuthController::class, 'authenticate']);
