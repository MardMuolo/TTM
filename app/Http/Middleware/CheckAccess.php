<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, \Closure $next, $model)
    {
        // utilisation de notre gate dans notre middleware
        if (!Gate::allows('access', $model)) {
            abort(403, 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette ressource.');
        }

        return $next($request);
    }
}
