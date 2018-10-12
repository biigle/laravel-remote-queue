<?php

namespace Biigle\Modules\Gpu\Jobs;

use Queue;
use Biigle\Jobs\Job;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Biigle\Modules\Gpu\Contracts\GpuResponse;

class GpuJob extends Job implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The response URL.
     *
     * @var string
     */
    protected $responseUrl;

    /**
     * Set the URL to which the response should be sent to.
     *
     * @param string $url
     */
    public function setResponseUrl($url)
    {
        $this->responseUrl = $url;
    }

    /**
     * Get the URL to which the response should be sent to.
     *
     * @return string
     */
    public function getResponseUrl()
    {
        return $this->responseUrl;
    }

    /**
     * Submit the response that should be sent back to the BIIGLE instance.
     *
     * @param Job $response Job with data to be sent back and be executed on the BIIGLE instance.
     */
    public function submitResponse(Job $response)
    {
        // Create new GpuResponse and push it to the regular queue.
    }
}
