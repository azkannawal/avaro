<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/login';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        // });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware(['web', 'isSuperAdmin'])
                ->prefix('superAdmin')
                ->name('superAdmin.')
                ->group(base_path('routes/Auth/superAdmin/routes.php'));

            Route::middleware(['web', 'isAdmin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/Auth/admin/routes.php'));

            Route::middleware(['web', 'isKepalaKantor'])
                ->prefix('kepalaKantor')
                ->name('kepalaKantor.')
                ->group(base_path('routes/Auth/kepalaKantor/routes.php'));

            Route::middleware(['web', 'isPool'])
                ->prefix('pool')
                ->name('pool.')
                ->group(base_path('routes/Auth/pool/routes.php'));

            Route::middleware(['web', 'isService'])
                ->prefix('service')
                ->name('service.')
                ->group(base_path('routes/Auth/service/routes.php'));
        });
    }
}
