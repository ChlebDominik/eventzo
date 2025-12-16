<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureOrganizer
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->isOrganizer()) {
            return redirect()->route('events.index')
                ->with('error', 'Prístup len pre organizátorov.');
        }

        return $next($request);
    }
}
