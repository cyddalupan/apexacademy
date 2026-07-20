<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompany
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // Super admins bypass company scoping
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (!$user->company_id) {
            abort(403, 'No company assigned.');
        }

        // Scope route model binding by company
        $request->merge(['_company_id' => $user->company_id]);
        
        return $next($request);
    }
}
