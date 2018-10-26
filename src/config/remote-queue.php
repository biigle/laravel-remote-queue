<?php

return [

    /*
    | Accept and process jobs sent to this application instance.
    */

    'listen' => env('REMOTE_QUEUE_LISTEN', false),

    /*
    | API endpoint to receive new jobs.
    */

    'endpoint' => env('REMOTE_QUEUE_ENDPOINT', 'api/v1/remote-queue'),

    /*
    | Use this queue connection to process received jobs.
    | If `null`, the default connection is used.
    */

    'connection' => env('REMOTE_QUEUE_CONNECTION', null),

    /*
    | Accept jobs only if they provide one of these tokens.
    */

    'accept-tokens' => array_filter(explode(',', env('REMOTE_QUEUE_ACCEPT_TOKENS'))),

];
