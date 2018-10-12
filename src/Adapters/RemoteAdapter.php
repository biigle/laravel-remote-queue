<?php

namespace Biigle\Modules\Gpu\Adapters;

use Biigle\Modules\Gpu\GpuResponse;
use Biigle\Modules\Gpu\Jobs\GpuJob;
use Biigle\Modules\Gpu\Contracts\Adapter;

// Gpu jobs are serialized and transferred via HTTP to the configured URL of the GPU
// server. The GPU server unserializes the job and processes it. The response is
// serialized again and transferred back using the responseUrl of the job object.
// In BIIGLE, the response is unserialized and pushed to the regular queue.
//
// This adapter assembles the response URL. It contains a long, unique token for each
// job. The token is stored in the database until the job response is returned.

class RemoteAdapter implements Adapter
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
    public function pushResponse(GpuResponse $response)
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
