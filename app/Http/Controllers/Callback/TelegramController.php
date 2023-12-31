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
        $data = $telegram->validate($request);

        auth()->user()->update([
           'telegram_id' => $data->getId(),
        ]);

        notify()->success("You subscribe to Telegram bot",position: 'topRight');

        return redirect()->route('profile.edit');
    }
}
