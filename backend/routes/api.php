<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;

Route::controller(UserController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
        
Route::middleware('auth:sanctum')->group( function () {
    Route::resource('products', ProductController::class);
});

Route::fallback(function () {
    return response()->json(['success'=>false, 'message'=>'Sorry Not Found'], 404);
});