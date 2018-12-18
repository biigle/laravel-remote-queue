<?php

namespace Biigle\RemoteQueue\Tests\Http\Middleware;

use Biigle\RemoteQueue\Tests\TestCase;

class WhitelistIpsTest extends TestCase
{
    public function testHandle()
    {
        config(['remote-queue.accept_tokens' => ['mytoken']]);
        config(['remote-queue.accept_ips' => ['192.168.100.1']]);

        $this->get('api/v1/remote-queue/default/size', [
                'Authorization' => 'Bearer mytoken',
                'REMOTE_ADDR' => '192.168.100.2',
            ])->assertStatus(401);

        $this->get('api/v1/remote-queue/default/size', [
                'Authorization' => 'Bearer mytoken',
                'REMOTE_ADDR' => '192.168.100.1',
            ])->assertStatus(200);
    }
}
