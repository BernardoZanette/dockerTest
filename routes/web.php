<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PeopleController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'OK'
    ]);
});

Route::get('/somar', function(Request $request) {
    $soma = array_sum($request->all());
    return response()->json([
        "message" => 'OK',
        "soma" => $soma
    ]);
}); 

Route::prefix('/people')
    ->middleware([JwtMiddleware::class])
    ->group(function() 
{
    Route::get('/list', [PeopleController::class, 'fetchAll']);
    
    Route::post('/store', [PeopleController::class, 'store']);
}); 

Route::prefix('/user')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);

    Route::middleware([JwtMiddleware::class])->get('/logout', [JWTAuthController::class, 'logout']);
});