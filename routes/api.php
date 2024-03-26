<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\OpenAIController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/authenticate', [ApiController::class, 'authenticateGameSession']);

    Route::middleware('token')->group(function () {
        Route::post('/auth', function (Request $request) {
            return response()->json(['status' => 'success', 'message' => 'You are authenticated!']);
        });

        Route::post('/chat', [OpenAIController::class, 'getOpenAIResponse']);
    });
});



