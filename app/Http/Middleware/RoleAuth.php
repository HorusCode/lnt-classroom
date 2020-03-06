<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        $userRole = $request->user()->role->name;
        if($userRole != $role) {
            return response()->json([
                'status' => 'false',
                'message' => [
                    'role' => 'У вас нет прав на эту операцию'
                ]
            ])->setStatusCode(400, 'Invalid role');
        }
        return $next($request);

    }
}
