<?php

namespace Biigle\Modules\Gpu;

use Biigle\Jobs\Job;
use Biigle\Modules\Gpu\Jobs\GpuJob;
use Biigle\Modules\Gpu\Contracts\Adapter;

class GpuJobHandler
{
    /**
     * The adapter to use for submitting the jobs.
     *
     * @var Adapter
     */
    protected $adapter;

    /**
     * Create a new instance.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->adapter = new $config['adapter'];
        $this->adapter->setConfig($config);
    }

    /**
     * Submit a job to the GPU server.
     *
     * @param GpuJob $job
     */
    public function push(GpuJob $job)
    {
        $this->adapter->push($job);
    }

    /**
     * Return a job response back to BIIGLE.
     *
     * @param Job $response
     */
    public function pushResponse(Job $response)
    {
        $this->adapter->pushResponse($job);
    }
}
