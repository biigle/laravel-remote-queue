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
        // Can't be tested with QueueFake until Laravel 5.6.18.
        // Queue::push(new TestJob, '', 'myqueue');
        // $response = $this->withoutMiddleware()->get('api/v1/remote-queue/myqueue/size');
        // $this->assertEquals('1', $response->getContent());
    }

    public function testStore()
    {
        $payload = ['job' => serialize(new TestJob), 'data' => 'mydata'];
        $payload2 = ['job' => 'DoesNotExist'];
        $mock = Mockery::mock();
        $mock->shouldReceive('push')
            ->once()
            ->with(Mockery::type(TestJob::class), 'mydata', 'myqueue');
        Queue::shouldReceive('connection')->once()->andReturn($mock);
        $this->withoutMiddleware()
            ->postJson('api/v1/remote-queue/myqueue')
            // Job is required
            ->assertStatus(422);

        $this->withoutMiddleware()
            ->postJson('api/v1/remote-queue/myqueue', $payload2)
            // Job class does not exist
            ->assertStatus(422);

        $this->withoutMiddleware()
            ->postJson('api/v1/remote-queue/myqueue', $payload)
            ->assertStatus(200);
    }
}

class TestJob
{
}
