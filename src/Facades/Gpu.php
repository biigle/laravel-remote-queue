<?php

namespace Biigle\Modules\Gpu\Facades;

use Illuminate\Support\Facades\Facade;

class Gpu extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gpu';
    }
}
