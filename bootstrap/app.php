<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::domain('admin.mysteryvisits.nl')
                ->middleware('web')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            Route::domain('portal.mysteryvisits.nl')
                ->middleware('web')
                ->name('company.')
                ->group(base_path('routes/company.php'));

            Route::domain('mijn.mysteryvisits.nl')
                ->middleware('web')
                ->group(base_path('routes/web.php'));

            // Local development routing
            if (app()->isLocal()) {
                Route::middleware('web')
                    ->prefix('admin')
                    ->name('admin.')
                    ->group(base_path('routes/admin.php'));

                Route::middleware('web')
                    ->prefix('portal')
                    ->name('company.')
                    ->group(base_path('routes/company.php'));

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));
            }

            Route::domain('admin.mysteryvisits.nl')->get('/test', function () {
                return [
                    'current_host' => request()->getHost(),
                    'scheme_host' => request()->getSchemeAndHttpHost(),
                    'forced_root' => url('/'),
                    'route_url' => route('admin.login-action'), // or any named route you want
                ];
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'set-url' => \App\Http\Middleware\SetAppUrl::class,
        ]);

        $middleware->append([
            \App\Http\Middleware\SetAppUrl::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web([
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
