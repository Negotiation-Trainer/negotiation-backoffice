<?php

namespace App\Http\Controllers;

use App\Models\GameCode;

use Illuminate\Http\Request;

class GameCodeController extends Controller
{
    public function all()
    {
        return GameCode::all()->except(['created_at', 'updated_at']);
    }

    public function find($id)
    {
        return GameCode::where('id', $id)->firstOrFail();
    }
}
