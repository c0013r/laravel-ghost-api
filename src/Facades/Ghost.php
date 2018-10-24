<?php

namespace c0013r\GhostAPI\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Ghost
 * @package c0013r\GhostAPI\Facades
 *
 * @method static \c0013r\GhostAPI\Providers\PostProvider posts()
 */
class Ghost extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Ghost';
    }
}
