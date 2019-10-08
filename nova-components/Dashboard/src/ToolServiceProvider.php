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
            $divergence = Document::whereNull('expected_at')
                ->orWhere('collected_at', NULL)
                ->count();

            $delivered = Document::where('delivered_at','>=',Carbon::now()->startOfYear()->toDateString())
                ->where('delivered_at','<=',Carbon::now()->toDateString())
                ->whereNotNull('expected_at')
                ->get();

            collect($delivered)
                ->map(function ($item) {
                    $item->later = !Carbon::createFromFormat('Y-m-d H:i:s', $item->delivered_at)->lessThanOrEqualTo(Carbon::createFromFormat('Y-m-d H:i:s', $item->expected_at));
                    return $item;
                })->all();

            $delivered_expected_count = collect($delivered)->where('later', true)->count();

            Nova::provideToScript([
                'year' => Carbon::now()->year,
                'delivered_count' => count($delivered),
                'general_performance' => ($delivered_expected_count*100)/count($delivered),
                'divergence' => $divergence
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
