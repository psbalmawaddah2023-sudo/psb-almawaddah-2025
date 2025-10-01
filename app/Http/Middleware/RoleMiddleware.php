<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
    public function handle($request, Closure $next, ...$roles) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Pastikan relasi ada & cek berdasarkan kolom 'role'
        if (!$user->role || !in_array($user->role->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
