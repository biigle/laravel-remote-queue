<?php

namespace Biigle\Modules\Gpu\Contracts;

use Biigle\Jobs\Job;

interface GpuJob
{
    /**
     * Set the URL of the API endpoint to post the response of this job to.
     *
     * @param string $url
     */
    public function setResponseUrl($url);

    /**
     * Get the URL of the API endpoint to post the response of this job to.
     *
     * @return string
     */
    public function getResponseUrl();

    /**
     * Submit the response with the results of the processed job.
     *
     * @param Job $response
     */
    public function submitResponse(Job $response);
}
