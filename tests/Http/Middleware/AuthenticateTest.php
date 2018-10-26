<?php

namespace Biigle\RemoteQueue\Tests\Http\Middleware;

use Biigle\RemoteQueue\Tests\TestCase;

class AuthenticateTest extends TestCase
{
    public function testHandle()
    {
        config(['remote-queue.accept-tokens' => ['mytoken']]);

        $this->get('api/v1/remote-queue/default/size')->assertStatus(401);

        $this->get('api/v1/remote-queue/default/size', [
            'Authorization' => 'Bearer mytoken',
        ])->assertStatus(200);
    }
}
