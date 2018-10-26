<?php

namespace Biigle\RemoteQueue\Tests;

use Queue;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Bus\Queueable;
use GuzzleHttp\Handler\MockHandler;
use Biigle\RemoteQueue\RemoteQueue;

class RemoteQueueTest extends TestCase
{
   public function setUp()
   {
      parent::setUp();
      config(['queue.connections.remote' => [
         'driver' => 'remote',
         'queue' => 'default',
         'url' => 'http://localhost/api/remote-queue',
         'username' => 'test',
         'password' => 'test',
      ]]);
   }

   public function testDriver()
   {
      $queue = Queue::connection('remote');
      $this->assertInstanceOf(RemoteQueue::class, $queue);
   }

   public function testSize()
   {
      $mock = new MockHandler([new Response(200, [], 123)]);
      $handler = HandlerStack::create($mock);
      $container = [];
      $handler->push(Middleware::history($container));
      $client = new Client(['handler' => $handler]);
      $queue = new RemoteQueue($client);

      $size = $queue->size();
      $this->assertEquals(123, $size);
      $this->assertEquals('queue/default/size', $container[0]['request']->getUri());
   }

   public function testSizeQueue()
   {
      $mock = new MockHandler([new Response(200, [], 123)]);
      $handler = HandlerStack::create($mock);
      $container = [];
      $handler->push(Middleware::history($container));
      $client = new Client(['handler' => $handler]);
      $queue = new RemoteQueue($client);

      $size = $queue->size('gpu');
      $this->assertEquals(123, $size);
      $this->assertEquals('queue/gpu/size', $container[0]['request']->getUri());
   }

   public function testPush()
   {
      $mock = new MockHandler([new Response(200)]);
      $handler = HandlerStack::create($mock);
      $container = [];
      $handler->push(Middleware::history($container));
      $client = new Client(['handler' => $handler]);
      $queue = new RemoteQueue($client);

      $queue->push(new TestJob);
      $request = $container[0]['request'];
      $this->assertEquals('POST', $request->getMethod());
      $this->assertEquals('queue/default', $request->getUri());
      $this->assertContains('"commandName":"Biigle\\\RemoteQueue\\\Tests\\\TestJob"', $request->getBody()->getContents());
   }

   public function testPushQueue()
   {
      $mock = new MockHandler([new Response(200)]);
      $handler = HandlerStack::create($mock);
      $container = [];
      $handler->push(Middleware::history($container));
      $client = new Client(['handler' => $handler]);
      $queue = new RemoteQueue($client);

      $queue->push(new TestJob, '', 'gpu');
      $this->assertEquals('queue/gpu', $container[0]['request']->getUri());
   }
}

class TestJob
{
   use Queueable;
}
