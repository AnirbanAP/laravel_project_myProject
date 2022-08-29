<?php

use App\Http\Controllers\loginController;
use App\Http\Controllers\postController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_data', function(){
  return 'Hello';
});

Route::get('/posts',[postController::class,'index']);
Route::post('/post',[postController::class,'store']);
Route::get('/posts/{id}',[postController::class,'show']);
Route::put('/posts/{id}',[postController::class,'update']);
Route::delete('/posts/{id}',[postController::class,'destroy']);


Route::post('/register',[loginController::class,'register']);
Route::post('/login',[loginController::class,'login']);

Route::group(['middileware' =>['auth:sanctum']],function(){
  Route::get('/posts',[postController::class,'index']);
  Route::post('/post',[postController::class,'store']);
  Route::get('/posts/{id}',[postController::class,'show']);
  Route::put('/posts/{id}',[postController::class,'update']);
  Route::delete('/posts/{id}',[postController::class,'destroy']);
  Route::post('/logout',[loginController::class,'logout']);
});