<?php

namespace App;

use App\Request;
use App\Route;

class Application
{
    public static function handle(Request $request)
    {
        Route::dispatch($request);
    }
}
