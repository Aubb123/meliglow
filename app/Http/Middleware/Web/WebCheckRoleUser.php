<?php

namespace App\Http\Middleware\Web;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebCheckRoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role_id, $roles)) {
            return $next($request);
        }else{
            return abort(403);
            // return redirect()->route('frontend.index')->with('error', "Vous n'avez pas les permissions nécessaires pour accéder à cette page.");
        }

        return $next($request);
    }
}
