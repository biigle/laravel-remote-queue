<?php

namespace Biigle\RemoteQueue\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $payload = $request->getContent();

        if (!$payload) {
            return new Response('Job payload is required', 422);
        }

        $json = json_decode($payload, true);

        if (is_null($json)) {
            return new Response('Job payload is no valid JSON', 422);
        }

        if (!class_exists(array_get($json, 'data.commandName'))) {
            return new Response('Job payload is no valid JSON', 422);
        }

        app('queue')->connection(config('remote-queue.connection'))
            ->pushRaw($payload, $queue);

    }
}
