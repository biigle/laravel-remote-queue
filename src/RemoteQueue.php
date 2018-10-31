<?php

namespace Biigle\RemoteQueue;

use GuzzleHttp\Client;
use Illuminate\Queue\Queue;
use Illuminate\Support\Str;
use Illuminate\Queue\Connectors\ConnectorInterface;
use Illuminate\Contracts\Queue\Queue as QueueContract;

class RemoteQueue extends Queue implements QueueContract
{
    /**
     * Guzzle client for the configured remote entpoint
     *
     * @var Client
     */
    protected $client;

    /**
     * Default queue to push jobs on the remote end
     *
     * @var string
     */
    protected $default;

    /**
     * Create a new remote queue instance.
     *
     * @param Client $client Guzzle client for the configured remote entpoint
     * @param string $default Default queue to push jobs on the remote end
     */
    public function __construct(Client $client, $default = 'default')
    {
        $this->client = $client;
        $this->default = $default;
    }

    /**
     * Get the size of the queue.
     *
     * @param  string  $queue
     * @return int
     */
    public function size($queue = null)
    {
        $queue = $this->getQueue($queue);
        $response = $this->client->get("{$queue}/size");

        return (int) $response->getBody()->getContents();
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->pushRaw($this->createPayload($job, $data), $queue);
    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @param  array   $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        $queue = $this->getQueue($queue);

        return $this->client->post("{$queue}", ['body' => $payload]);
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTimeInterface|\DateInterval|int  $delay
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        // A delay is unsupported for now.
        $this->push($job, $data, $queue);
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        //
    }

    /**
     * Get the queue or return the default.
     *
     * @param  string|null  $queue
     * @return string
     */
    protected function getQueue($queue)
    {
        return $queue ?: $this->default;
    }

    /**
     * Create a payload for an object-based queue handler.
     *
     * @param  mixed  $job
     * @return array
     */
    protected function createObjectPayload($job)
    {
        return [
            'job' => serialize(clone $job),
        ];
    }

    /**
     * Create a typical, string based queue payload array.
     *
     * @param  string  $job
     * @param  mixed  $data
     * @return array
     */
    protected function createStringPayload($job, $data)
    {
        return [
            'job' => $job,
            'data' => $data,
        ];
    }
}
