# Remote Queue

Submit jobs to and receive jobs from other Laravel or Lumen instances.

[![Build Status](https://api.travis-ci.org/biigle/laravel-remote-queue.svg?branch=master)](https://travis-ci.org/biigle/laravel-remote-queue)

## Installation

```
composer require biigle/laravel-remote-queue
```

### Laravel

The service provider is auto-discovered by Laravel.

### Lumen

Add `$app->register(Biigle\RemoteQueue\RemoteQueueServiceProvider::class);` to `bootstrap/app.php`.

## Usage

This package can be used to submit queued jobs to another Laravel or Lumen application, receive jobs from another application or both.

### Receive jobs

By default, this package does not allow receiving of jobs from another application. To allow this, set the `remote-queue.listen` configuration to `true`. Tokens are used to authenticate incoming requests. A token is just some long random string in this case. Configure `remote-queue.accept-tokens` with all tokens that are accepted. All received jobs which are successfully authenticated are pushed to a "regular" queue of this application and processed by the queue worker.

**Important:** Make sure that the job class exists in both the submitting and receiving application.

### Submit jobs

Jobs pushed to the remote queue are transmitted via HTTP and processed on another application. To use the remote queue, configure a queue connection in the `queue.connections` config to use the `remote` driver. Example:

```php
[
   'driver' => 'remote',
   // Default queue of the remote host to push jobs to.
   'queue' => 'default',
   // The remote queue API endpoint of the remote host. Don't forget the trailing slash!
   'url' => 'http://192.168.100.100/api/v1/remote-queue/',
   // Token to use for authentication on the remote host.
   'token' => 'IoO2l7UKZfso5zQloF2XvAShEbAR5a9M8u+WBfg0HgI=',
   // Optional additional request options for the GuzzleHttp client.
   'request_options' => [],
]
```

You can now dispatch jobs to the remote queue connection just like any other connection.

```php
use App\Jobs\MyJob;

MyJob::dispatch($data)->onConnection('remote');
```

### Submit/Response Pattern

We developed this package to be able to process jobs on a remote machine with GPU. To return the computed results, we applied what we call the "submit/response" pattern.

In this pattern, this package is installed on both Laravel/Lumen instances (let's call them A and B). In instance A, the remote queue is configured to push jobs to instance B (the one with the GPU). In instance B, the remote queue is configured to push jobs to instance A. New GPU jobs are submitted from instance A to the remote queue on instance B. Once the results are computed, they are returned as a "response job" to the remote queue on instance A where the results can be further processed.

## Configuration

You can override any of these configuration options of the `remote-queue` config either directly or via environment variables:

### remote-queue.listen

Default: `false`
Environment: `REMOTE_QUEUE_LISTEN`

Accept and process jobs sent to this application instance.

### remote-queue.endpoint

Default: `api/v1/remote-queue`
Environment: `REMOTE_QUEUE_ENDPOINT`

API endpoint to receive new jobs.

### remote-queue.connection

Default: `null`
Environment: `REMOTE_QUEUE_CONNECTION`

Use this queue connection to process received jobs. If `null`, the default connection is used.

### remote-queue.accept-tokens

Default: `[]`
Environment: `REMOTE_QUEUE_ACCEPT_TOKENS`

Accept jobs only if they provide one of these tokens. Specify tokens as comma separated list if you use the environment variable. One way to generate tokens is this command: `head -c 32 /dev/urandom | base64`.
