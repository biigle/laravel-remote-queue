# Remote Queue

Submit jobs to other Laravel or Lumen instances.

## Installation

```
composer config repositories.laravel-remote-queue vcs https://github.com/biigle/larave-remote-queue
composer require biigle/laravel-remote-queue
```

### Laravel

The service provider is auto-discovered by Laravel.

### Lumen

Add `$app->register(Biigle\RemoteQueue\RemoteQueueServiceProvider::class);` to `bootstrap/app.php`.

## Configuration

todo

## Usage

To use the remote queue, configure a queue connection in the `queue.connections` config to use the `remote` driver:

```php
[
   'driver' => 'remote',
   // Default queue of the remote host to push jobs to.
   'queue' => 'default',
   // The remote queue API endpoint of the remote host.
   'url' => 'http://192.168.100.100/api/v1/remote-queue',
   // Basic auth username to use for authentication on the remote host.
   'username' => '',
   // Basic auth password to use for authentication on the remote host.
   'password' => '',
]
```

```php
use App\Jobs\MyJob;

MyJob::dispatch($data)->onConnection('remote');
```

## Submit/Response Pattern

We developed this package to be able to process jobs on a remote machine with GPU. To return the computed results, we applied what we call the "submit/response" pattern.

In this pattern, this package is installed on both Laravel/Lumen instances (let's call them A and B). In instance A, the remote queue is configured to push jobs to instance B (the one with the GPU). In instance B, the remote queue is configured to push jobs to instance A. New GPU jobs are submitted from instance A to the remote queue on instance B. Once the results are computed, they are returned as a "response job" to the remote queue on instance A where the results can be further processed.
