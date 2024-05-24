<?php

namespace App\Http\Controllers;

use App\Models\GameCode;
use Illuminate\Database\Eloquent\Collection;

class GameCodeController extends Controller
{
    public function all(): Collection
    {
        return GameCode::all()->except(['created_at', 'updated_at']);
    }

    public function find($id): GameCode
    {
        return GameCode::where('id', $id)->firstOrFail();
    }
}
