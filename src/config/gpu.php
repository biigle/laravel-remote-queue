<?php

return [

    /*
    | The GPU adapter to use. The adapters used by the BIIGLE instance and the GPU
    | server must match.
    |
    | Default is 'Biigle\Modules\Gpu\Adapters\Remote'.
    */

    'adapter' => env('GPU_ADAPTER', Biigle\Modules\Gpu\Adapters\Remote::class),

    /*
    | The remote URL where the GPU server can be accessed.
    | This needs to be configured on the BIIGLE instance.
    */

    'server_url' => env('GPU_SERVER_URL', ''),

    /*
    | The username to use for authentication with the GPU server.
    | This needs to be configured on the BIIGLE instance.
    */

    'server_username' => env('GPU_SERVER_USERNAME', ''),

    /*
    | The password to use for authentication with the GPU server.
    | This needs to be configured on the BIIGLE instance.
    */

    'server_password' => env('GPU_SERVER_PASSWORD', ''),

    /*
    | Name of the queue to push GPU jobs to on the GPU server.
    |
    | Default is 'gpu'.
    */

    'queue' => 'gpu',

];
