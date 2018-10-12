<?php

namespace Biigle\RemoteQueue\Tests;

use Illuminate\Contracts\Console\Kernel;
use Biigle\RemoteQueue\RemoteQueueServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
   /**
     * Boots the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        // We create a full Laravel app here for testing purposes. The RemoteQueue
        // needs access to the application config and the filesystem singleton.
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        $app->register(RemoteQueueServiceProvider::class);

        return $app;
    }
}
