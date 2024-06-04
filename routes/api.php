<?php

use App\Http\Controllers\GameController;

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
    Route::post('/authenticate', [GameController::class, 'authenticateGameSession']);

    Route::middleware('token')->group(function () {
        Route::post('/auth', function () {
            return response()->json(['status' => 'success', 'message' => 'You are authenticated!']);
        });

        Route::post('/game-config', [GameController::class, 'gameConfig']);

        Route::prefix('chat')->group(function () {
            Route::post('/convert-to-trade', [OpenAIController::class, 'convertToTrade'])->name('chat.convert-to-trade');
            Route::post('/accept-deal', [OpenAIController::class, 'acceptDeal']);
            Route::post('/reject-deal', [OpenAIController::class, 'rejectDeal']);

            Route::post('/counter-offer', [OpenAIController::class, 'counterOffer']);

            //Converts a trade offer into a chat dialogue (used for AI responses)
            Route::post('/convert-to-chat', [OpenAIController::class, 'convertToChat'])->name('chat.convert-to-chat');
        });

    });
});
