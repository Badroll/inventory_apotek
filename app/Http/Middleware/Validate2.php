<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
Use Session;

class Validate2
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has("user")) {
            return redirect(url('auth/login'))->with('error', 'Silahkan login dahulu untuk mengaksees inventory');
        }else{
            $user = Session::get("user");
            if($user->{"role"} != 2){
                //dd($user);
                return back()->with("error", "Anda tidak memliki hak akses untuk menu ini");
            }
        }

        return $next($request);
    }
}
