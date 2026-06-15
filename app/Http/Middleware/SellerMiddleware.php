<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SellerMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user || ! $user->isSeller()) {
            abort(403);
        }

        return $next($request);
    }
}
