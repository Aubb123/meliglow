<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebCheckUserEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Vérifie si l'email de l'utilisateur est vérifié
        if ($user && is_null($user->email_verified_at)) {
            return redirect()->route('email.verifie.use-otp');
        }

        return $next($request);
    }
}
