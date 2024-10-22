<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Controleer of de ingelogde gebruiker een admin is
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirect naar een foutpagina of een andere pagina als de gebruiker geen admin is
        return redirect('/home')->with('error', 'Toegang geweigerd.');
    }


}
