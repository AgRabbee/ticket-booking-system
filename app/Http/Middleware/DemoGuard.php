<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

/**
 * Stops the published demo accounts (config/demo.php) from running
 * destructive actions. Real accounts pass straight through.
 */
class DemoGuard
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->email, config('demo.accounts', []), true)) {
            return $next($request);
        }

        // Approving a user or company is fine; pausing or denying one removes access.
        if ($request->route('status') === 'active') {
            return $next($request);
        }

        $kind = str_contains($request->path(), 'delete') ? 'delete' : 'change';
        Alert::warning('Demo account', config('demo.messages.' . $kind));

        return redirect()->back();
    }
}
