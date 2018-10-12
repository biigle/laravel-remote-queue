<?php

namespace Biigle\Modules\Gpu\Jobs;

use Biigle\Jobs\Job;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GpuResponse extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The response URL.
     *
     * @var string
     */
    protected $url;

    /**
     * The response data.
     *
     * @var Job
     */
    protected $payload;

    /**
     * Create a new instance
     *
     * @param string $url Response URL
     * @param Job $payload Response data
     */
    public function __construct($url, Job $payload)
    {
        $this->url = $url;
        $this->payload = $payload;
    }

    /**
     * Get the response URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the response data
     *
     * @return Job
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Get the configured adapter and push the payload job to it.
    }
}
