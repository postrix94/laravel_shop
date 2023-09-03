<?php

namespace App\Http\Controllers\Callback;

use App\Http\Controllers\Controller;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(TelegramLoginAuth $telegram, Request $request)
    {
        dd($telegram->validate($request));
    }
}
