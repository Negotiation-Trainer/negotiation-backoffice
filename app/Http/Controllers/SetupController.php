<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupRequest;
use App\Models\Pricing;
use App\Models\User;
use Database\Seeders\PricingSeeder;
use Inertia\Inertia;

class SetupController extends Controller
{
    public function __invoke()
    {
        if (User::count() === 0) {

            //check if seed data is present in pricing table
            if (Pricing::count() === 0) {
                //run seeder
                $seeder = new PricingSeeder();
                $seeder->run();
            }
            return Inertia::render('Setup');
        }

        return redirect()->route('game-sessions');

    }
}
