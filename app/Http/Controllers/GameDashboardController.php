<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameSessionRequest;
use App\Http\Requests\GameSessionUpdateRequest;
use App\Models\GameCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class GameDashboardController extends Controller
{
    public function index(GameCodeController $gcController)
    {
        $codeList = $gcController->all();

        return Inertia::render('GameDashboard',
            [
                'gameCodes' => $codeList
            ]);
    }

    public function show($id, GameCodeController $gcController, CostsController $cc)
    {
        $game = $gcController->find($id);

        return Inertia::render('Games/ShowGame', [
            'session' => $game,
            'tokenList' => $game->sessionList,
            'costs' => $cc->getGameCosts($game)
        ]);
    }

    public function create()
    {
        return Inertia::render('Games/CreateGame');
    }

    public function store(GameSessionRequest $request)
    {
        try {
            $request->validated();

            //store the game
            $gameCode = GameCode::create($request->all());

            return response()->json([
                'message' => 'Game created',
                'data' => $gameCode
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error',
                'errors' => $e->getMessage()
            ]);
        }
    }

    public function update(GameSessionUpdateRequest $request)
    {
        try {
            $request->validated();
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ]);
        }
        $gameCode = GameCode::find($request->id);

        $gameCode->update($request->all());

        return response()->json([
            'message' => 'Game updated',
            'data' => $gameCode
        ]);
    }

    public function costs(CostsController $cc)
    {
        $costs = $cc->calculateTotal();

        return Inertia::render('CostsDashboard', [
            'costs' => $costs
        ]);
    }
}
