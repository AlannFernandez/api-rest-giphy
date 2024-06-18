<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\GiphyController;
use App\Traits\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('healt', function(){
    return "API is healthy";
});


Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login'])->middleware('log.requests');

Route::middleware(['auth:api', 'log.requests'])->group(function () {
    Route::get('get-user', [AuthController::class, 'userInfo']);
    Route::get('/gifs/search', [GiphyController::class, 'searchGifs']);
    Route::get('/gifs/{id}', [GiphyController::class, 'searchId']);
    Route::post('/gifs/save',[GiphyController::class, 'saveFavoriteGif']);
});


// Pages not found
Route::get('/{any}', [Controller::class, 'pageNotFound'])->where('any', '.*');