<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    #get
    Route::get('/investigations', [ApiController::class, 'investigations']);

    #post
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/categories', [ApiController::class, 'categories']);
    Route::post('/add-collection', [ApiController::class, 'add_collection']);
    Route::post('/update-collection', [ApiController::class, 'update_collection']);
    Route::post('/add-business', [ApiController::class, 'add_business']);
    Route::post('/add-exploitation', [ApiController::class, 'add_exploitation']);
    
}); 
