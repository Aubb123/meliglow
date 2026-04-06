<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Middleware de non-authentification
        $user = $request->user();

        // Middleware de non-authentification
        if($user && $user->id){
            return redirect()->route('frontend.index')->with('error', 'Vous êtes déjà authentifié.');
        }   

        return $next($request);
    }
}
