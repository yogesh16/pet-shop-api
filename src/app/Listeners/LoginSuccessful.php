<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LoginSuccessful
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserLogin $event
     *
     * @return void
     */
    public function handle(UserLogin $event)
    {
        $user = $event->user;

        //update last login time
        $user->last_login_at = Carbon::now();

        Log::debug('[LoginEvent]', ['Last lgoin updated']);
    }
}
