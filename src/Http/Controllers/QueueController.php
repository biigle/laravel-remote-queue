<?php

namespace Biigle\RemoteQueue\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueueController extends Controller
{
    /**
     * Get the size of a queue
     *
     * @param string $queue
     *
     * @return int
     */
    public function show($queue)
    {
        return app('queue')->connection()->size($queue);
    }

    /**
     * Accept a new job and push it to the local queue.
     *
     * @param Request $request
     * @param string $queue
     */
    public function store(Request $request, $queue)
    {
        app('validator')->make($request->all(), [
            'job' => 'required',
            'data' => 'filled',
        ])->validate();

        $job = @unserialize($request->input('job'));

        if ($this->isIncompleteClass($job)) {
            return response()->json(['errors' => ['job' => ['Unknown job class']]], 422);
        } elseif (!$this->isWhitelistedJob($job)) {
            return response()->json(['errors' => ['job' => ['Job class not whitelisted']]], 422);
        }

        app('queue')->connection(config('remote-queue.connection'))
            ->push($job, $request->input('data', ''), $queue);
    }

    /**
     * Determine if the received job class exists.
     *
     * @param object $job Job class name
     *
     * @return boolean
     */
    protected function isIncompleteClass($job)
    {
        return !is_object($job) || $job instanceof __PHP_Incomplete_Class;
    }

    /**
     * Determine if the received job is whitelisted.
     *
     * @param object $job Job class name
     *
     * @return boolean
     */
    protected function isWhitelistedJob($job)
    {
        $whitelist = config('remote-queue.accept_jobs');

        return empty($whitelist) || in_array(get_class($job), $whitelist);
    }
}
