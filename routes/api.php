<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Public
Route::get('/test',function(){
    return response(['message'=>'Test OK'],200);
});
Route::post('/reg',[AuthController::class,'registration']);
Route::post('/login',[AuthController::class,'login']);

//protected
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/logout',[AuthController::class, 'logout']);
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
