<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (! Auth::check()) {
            return redirect()
                ->route('login');
        }

        $user = Auth::user();

        if (! $user instanceof User) {
            return redirect()
                ->route('login');
        }

        if (! $user->ativo) {
            Auth::logout();

            $request
                ->session()
                ->invalidate();

            $request
                ->session()
                ->regenerateToken();

            return redirect()
                ->route('login')
                ->with(
                    'error',
                    'Seu usuário está desativado.'
                );
        }

        if (! $user->isAdmin()) {
            abort(
                403,
                'Você não possui permissão para acessar esta página.'
            );
        }

        return $next($request);
    }
}
