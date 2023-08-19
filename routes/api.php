<?php

use App\Http\Controllers\Api\{
    ProductController,
    LoginController,
    RegisterController
};
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('products', ProductController::class);
    Route::post('logout', [LoginController::class, 'logout']);
});
