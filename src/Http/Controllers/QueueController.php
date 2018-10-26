<?php

namespace Biigle\RemoteQueue\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Queue\QueueManager;

class QueueController extends Controller
{
    /**
     * Get the size of a queue
     *
     * @param QueueManager $manager
     * @param string $queue
     *
     * @return int
     */
    public function show(QueueManager $manager, $queue)
    {
        return $manager->connection()->size($queue);
    }

    /**
     * Accept a new job and push it to the local queue.
     *
     * @param Request $request
     * @param QueueManager $manager
     * @param string $queue
     */
    public function store(Request $request, QueueManager $manager, $queue)
    {
        $payload = $request->getContent();

        if (!$payload) {
            return new Response('Job payload is required', 422);
        }

        $manager->connection(config('remote-queue.connection'))
            ->pushRaw($payload, $queue);

    }
}
