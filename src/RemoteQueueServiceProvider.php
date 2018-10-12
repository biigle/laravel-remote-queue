<?php

namespace Biigle\RemoteQueue;

use Illuminate\Queue\QueueManager;
use Illuminate\Support\ServiceProvider;

class RemoteQueueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(QueueManager $manager)
    {
        $manager->addConnector('remote', function() {
            return new RemoteConnector;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
