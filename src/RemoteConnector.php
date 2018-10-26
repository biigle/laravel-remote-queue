<?php

namespace Biigle\RemoteQueue;

use GuzzleHttp\Client;
use Illuminate\Queue\Connectors\ConnectorInterface;

class RemoteConnector implements ConnectorInterface
{
   /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $client = new Client([
            'base_uri' => $config['url'],
            'headers' => ['Authorization' => "Bearer {$config['token']}"]
        ]);

        return new RemoteQueue($client, $config['queue']);
    }
}
