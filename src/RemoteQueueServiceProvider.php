<?php

namespace Biigle\RemoteQueue;

use Illuminate\Routing\Router;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;
use Biigle\RemoteQueue\Http\Middleware\Authenticate;

class RemoteQueueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(QueueManager $manager, Router $router)
    {
        $manager->addConnector('remote', function() {
            return new RemoteConnector;
        });

        if (config('remote-queue.listen')) {
            $router->group([
                'prefix' => config('remote-queue.endpoint'),
                'namespace' => 'Biigle\RemoteQueue\Http\Controllers',
                'middleware' => Authenticate::class,
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
