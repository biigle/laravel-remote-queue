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
        $requestOptions = [];
        if (isset($config['request_options']) && is_array($config['request_options'])) {
            $requestOptions = $config['request_options'];
        }

        // The URI should not be overridable by custom request options.
        $requestOptions['base_uri'] = $config['url'];

        $client = new Client(array_merge_recursive($requestOptions, [
            'headers' => ['Authorization' => "Bearer {$config['token']}"],
        ]));

        return new RemoteQueue($client, $config['queue']);
    }
}
