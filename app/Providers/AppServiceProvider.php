<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // force call the default URL
        // URL::forceRootUrl(request()->getSchemeAndHttpHost());

        Schema::defaultStringLength(191);
        Schema::enableForeignKeyConstraints();

        Authenticate::redirectUsing(function ($request) {
            $prefix = $request->segments()[0];

            switch ($prefix) {
                case 'admin':
                    $prefix = 'admin';
                    break;
                case 'company':
                    $prefix = 'company';
                    break;
                default:
                    $prefix = null;
                    break;
            }

            return $request->expectsJson() ? null : route($prefix ? $prefix . '.login' : 'login');
        });

        RedirectIfAuthenticated::redirectUsing(function ($request) {
//            TODO : need to enable and modify this as needed
//            $guards = empty($guards) ? [null] : $guards;
//
//            foreach ($guards as $guard) {
//                if (Auth::guard($guard)->check() && $guard == 'web') {
//                    return redirect()->route('web.dashboard');
//                }elseif(Auth::guard($guard)->check() && $guard == 'admin') {
//                    return redirect()->route('admin.dashboard');
//                }
//            }
//
//            return $next($request);
        });
    }
}
