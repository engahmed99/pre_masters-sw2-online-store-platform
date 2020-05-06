<?php

namespace App\Http\Middleware;

use Closure;

class Security {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $safe = false;
        if ($request->input('token')) {
            $id = decrypt($request->token);
            $user = \App\User::find($id);
            if ($user && $user->user_type === 1)
                $safe = true;
        }
        if (!$safe) {
            return response()->json([
                        "status" => "failed",
                        "msg" => "Unauthorized or not valid user"
            ]);
        }

        return $next($request);
    }

}
