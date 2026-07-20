<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DevAutoLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (config('app.dev_mode') && !Auth::check()) {
            $user = User::find(1);
            if ($user) {
                Auth::login($user);
            }
        }

        return $next($request);
    }
}
