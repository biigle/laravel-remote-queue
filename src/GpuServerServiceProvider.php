<?php

namespace Biigle\Modules\Gpu;

use Illuminate\Support\ServiceProvider;

class GpuServerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/gpu.php' => base_path('config/gpu.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/gpu.php', 'gpu');
    }
}
