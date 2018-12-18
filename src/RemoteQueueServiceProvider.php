<?php

namespace Biigle\RemoteQueue;

use Illuminate\Support\ServiceProvider;
use Biigle\RemoteQueue\Http\Middleware\Authenticate;
use Biigle\RemoteQueue\Http\Middleware\WhitelistIps;

class RemoteQueueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['queue']->addConnector('remote', function() {
            return new RemoteConnector;
        });

        if (config('remote-queue.listen')) {
            $this->app['router']->group([
                'prefix' => config('remote-queue.endpoint'),
                'namespace' => 'Biigle\RemoteQueue\Http\Controllers',
                'middleware' => [Authenticate::class, WhitelistIps::class],
            ], function ($router) {
                $router->post('{queue}', 'QueueController@store');
                $router->get('{queue}/size', 'QueueController@show');
            });
        }

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/remote-queue.php', 'remote-queue');
    }
}
