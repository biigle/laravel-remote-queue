<?php

namespace Biigle\RemoteQueue;

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
        return new RemoteQueue;
    }
}
