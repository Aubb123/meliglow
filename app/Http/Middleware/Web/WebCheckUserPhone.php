<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebCheckUserPhone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Vérifie si le numéro de téléphone de l'utilisateur est vérifié
        if ($user && is_null($user->phone_verified_at)) {
            return redirect()->route('phone.verifie.use-otp');
        }

        return $next($request);
    }
}
