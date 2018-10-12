<?php

namespace Biigle\Tests\Modules\Gpu;

use Biigle\Tests\TestCase as BaseTestCase;
use Biigle\Modules\Gpu\GpuServerServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = parent::createApplication();
        // The tests run in a BIIGLE instance but we want to test the stuff for the GPU
        // server as well.
        $app->register(GpuServerServiceProvider::class);

        return $app;
    }
}
