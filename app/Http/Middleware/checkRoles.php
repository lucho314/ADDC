<?php

namespace App\Http\Middleware;

use Closure;

class checkRoles {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $parametros=func_get_args();
        $roles = array_splice($parametros, 2);
        if (auth()->user()->hasRoles($roles)) {
            return $next($request);
        }

        return response('no permiso');
    }



}

