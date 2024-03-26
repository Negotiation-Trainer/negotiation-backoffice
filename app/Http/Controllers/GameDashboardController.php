<?php

namespace App\Http\Controllers;

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

    public function costs(CostsController $cc)
    {
        $costs = $cc->calculateTotal();

        return Inertia::render('CostsDashboard', [
            'costs' => $costs
        ]);
    }
}
