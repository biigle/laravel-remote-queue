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

        if (is_object($job)) {
            if ($job instanceof __PHP_Incomplete_Class) {
                return response()->json(['errors' => ['job' => ['Unknown job class']]], 422);
            }
        } else {
            $job = $request->input('job');

            if (!class_exists($job)) {
                return response()->json(['errors' => ['job' => ['Unknown job class']]], 422);
            }
        }

        app('queue')->connection(config('remote-queue.connection'))
            ->push($job, $request->input('data', ''), $queue);
    }
}
