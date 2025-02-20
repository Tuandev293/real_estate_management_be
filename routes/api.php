<?php

use App\Http\Controllers\Api\BuildingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('buildings')->group(function () {
    Route::get('/', [BuildingController::class, 'index']);
    Route::get('/detail/{id?}', [BuildingController::class, 'findById']);
    Route::post('/create', [BuildingController::class, 'store']);
    Route::post('/edit/{id?}', [BuildingController::class, 'update']);
    Route::delete('/destroy/{id?}', [BuildingController::class, 'destroy']);
});
