<?php

namespace Biigle\Modules\Gpu\Contracts;

use Biigle\Jobs\Job;
use Biigle\Modules\Gpu\Jobs\GpuJob;

interface Adapter
{
    /**
     * Submit a job to the GPU server.
     *
     * @param GpuJob $job
     */
    public function push(GpuJob $job);

    /**
     * Return a job response back to BIIGLE.
     *
     * @param Job $response
     */
    public function pushResponse(Job $response);

    /**
     * Set the configuration of the adapter.
     *
     * @param array $config
     */
    public function setConfig(array $config);
}
