<?php

namespace Biigle\RemoteQueue\Tests\Http\Controllers;

use Queue;
use Mockery;
use Biigle\RemoteQueue\Tests\TestCase;

class QueueControllerTest extends TestCase
{
    public function testShow()
    {
        Queue::fake('myqueue');
        $response = $this->withoutMiddleware()->get('api/v1/remote-queue/myqueue/size');
        $this->assertEquals('0', $response->getContent());
        Queue::push(new TestJob, '', 'myqueue');
        $response = $this->withoutMiddleware()->get('api/v1/remote-queue/myqueue/size');
        $this->assertEquals('1', $response->getContent());
    }

    public function testStore()
    {
        $payload = json_encode(['data' => ['commandName' => TestJob::class]]);
        $payload2 = json_encode(['data' => ['commandName' => 'DoesNotExist']]);
        $mock = Mockery::mock();
        $mock->shouldReceive('pushRaw')->once()->with($payload, 'default');
        Queue::shouldReceive('connection')->once()->andReturn($mock);
        $this->withoutMiddleware()
            ->post('api/v1/remote-queue/default')
            // Payload is required
            ->assertStatus(422);

        $this->withoutMiddleware()
            ->call('POST', 'api/v1/remote-queue/default', [], [], [], [], '.,')
            // Payload is no valid JSON
            ->assertStatus(422);

        $this->withoutMiddleware()
            ->call('POST', 'api/v1/remote-queue/default', [], [], [], [], $payload2)
            // Job class does not exist
            ->assertStatus(422);

        $this->withoutMiddleware()
            ->call('POST', 'api/v1/remote-queue/default', [], [], [], [], $payload)
            ->assertStatus(200);
    }
}

class TestJob
{

}
