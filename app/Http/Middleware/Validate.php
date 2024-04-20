<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
Use Session;

class Validate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has("user")) {
            return redirect(url('auth/login'))->with('error', 'Silahkan login dahulu untuk mengaksees inventory');
        }else{
        }

        return $next($request);
    }
}
