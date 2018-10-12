# BIIGLE GPU Module

Handle communication between BIIGLE and the BIIGLE GPU server.

## Installation

This module needs to be installed both for the BIIGLE instance and the GPU server.

```
composer config repositories.gpu vcs https://github.com/biigle/gpu
composer require biigle/gpu
```

### BIIGLE

The service provider and `Gpu` facade are auto discovered by BIIGLE.

### GPU Server

Add `$app->register(Biigle\Modules\Gpu\GpuServerServiceProvider::class);` to `bootstrap/app.php`.

## Configuration

todo

## Usage

To submit a job to the GPU server, it must extend `Biigle\Modules\Gpu\Jobs\GpuJob`. A job instance can be submitted with `Gpu::push($job)` and will be executed on the GPU server. To return the result data back to the BIIGLE instance, the job must call `$this->submitResponse($response)` at the end of its `handle` method. The response object must extend `Biigle\Jobs\Job` and will be executed on the BIIGLE instance where it can handle storage of the result data.

Be aware that the GPU server has no database access. All required information needs to be stored in the `GpuJob`.

**Example:**

```php
use Gpu;
use Biigle\Jobs\Job;
use Biigle\Modules\Gpu\Jobs\GpuJob;

/*
 * Instances of this class are submitted to the GPU server with Gpu::push().
 */
class MyGpuJob extends GpuJob
{
    /*
     * Instances of this class are created in BIIGLE.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /*
     * But the handle() method is executed on the GPU server.
     */
    public function handle()
    {
        $result = $this->computeGpuStuff($data);
        $this->submitResponse(new MyGpuResponse($result));
    }
}

/*
 * Instances of this class are used as argument for GpuJob::submitResponse.
 */
class MyGpuResponse extends Job
{
    /*
     * Instances of this class are created on the GPU server.
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /*
     * But the handle() method is executed in BIIGLE.
     */
    public function handle()
    {
        $this->storeResultInDatabase($this->result);
    }
}

// In the BIIGLE instance:
Gpu::push(new MyGpuJob('some data'));
```
