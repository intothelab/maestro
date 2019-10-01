<?php

namespace Maestro\Dashboard;

use App\Document;
use Carbon\Carbon;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Maestro\Dashboard\Http\Middleware\Authorize;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'dashboard');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            $delivered_count = Document::where('delivered_at','>=',Carbon::now()->startOfYear()->toDateString())->where('delivered_at','<=',Carbon::now()->toDateString())->count();
            $documents_count = Document::where('collected_at','>=',Carbon::now()->startOfYear()->toDateString())->where('collected_at','<=',Carbon::now()->toDateString())->count();
            Nova::provideToScript([
                'delivered_count' => $delivered_count,
                'general_performance' => (($delivered_count/$documents_count)*100)
            ]);
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/dashboard')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
