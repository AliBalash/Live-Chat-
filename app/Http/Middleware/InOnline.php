<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class InOnline
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $users_online = User::where('last_activity', '>', now())->get();
        $users_offline = User::where('last_activity', '<', now())->get();

        if (isset($users_offline)) {
            foreach ($users_offline as $user_off){

                $user_off->is_online = false;
                $user_off->save();
            }
        }

        if (isset($users_online)) {
            foreach ($users_online as $user_on){

                $user_on->is_online = true;
                $user_on->save();
            }
        }
        if (auth()->check()) {
            $user = auth()->user();
            $user->last_activity = now()->addMinute(1);
            $user->is_online = true;
            $user->save();

        }
        return $next($request);
    }
}
