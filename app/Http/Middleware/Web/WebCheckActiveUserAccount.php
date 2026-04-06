<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebCheckActiveUserAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Vérifie si l'utilisateur est actif
        if ($user && $user->is_active == false) {
            return redirect()->route('account.disabled')->with('error', 'Votre compte est désactivé. Veuillez contacter le support.');
        }

        return $next($request);
    }
}
