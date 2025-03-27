<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est authentifié et est admin (email admin@pirata.fr)
        if (!Auth::check() || Auth::user()->email !== 'admin@pirata.fr') {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }
            return redirect('/dashboard')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette page');
        }

        return $next($request);
    }
}
