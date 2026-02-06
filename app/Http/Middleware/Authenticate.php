<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if($request->getHttpHost()){
            if($request->getHttpHost() == 'admin.mysteryvisits.nl'){
                return route('admin.login');
            }else if($request->getHttpHost() == 'portal.mysteryvisits.nl'){
                return route('company.login');
            }else{
                return route('login');
            }
        }
        // dd($request->getHttpHost());

        /*if (!$request->expectsJson()) {
            return $request->is('admin*')
                ? route('admin.login')
                : (
                    $request->is('company*')
                        ? route('company.login')
                        : route('login')
                );
        }*/

        return null;
    }
}
