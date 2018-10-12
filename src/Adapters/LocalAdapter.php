<?php

namespace Biigle\Modules\Gpu\Adapters;

use Biigle\Jobs\Job;
use Biigle\Modules\Gpu\Jobs\GpuJob;
use Biigle\Modules\Gpu\Contracts\Adapter;

// Push the GpuJob on the "gpu" queue. In the "local" setup the BIIGLE instance and the
// GPU server share a common Redis cache. This adapter pushes new jobs from BIIGLE to
// the "gpu" queue and the GPU server picks them up from there. The response is pushed
// from the GPU server to the regular queue and BIIGLE picks it up from there.
//
// In the local setup, only the "worker" service of the GPU server is running.

class LocalAdapter implements Adapter
{
    /**
     * {@inheritdoc}
     */
    public function push(GpuJob $job)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function pushResponse(Job $response)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function setConfig(array $config)
    {
        //
    }
}
