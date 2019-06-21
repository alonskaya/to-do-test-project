<?php

namespace App\Service\Initializer;

use App\Service\Auth;
use Klein\Klein;

/**
 * Class AuthInitializer
 * @package App\Service\Initializer
 */
class AuthInitializer implements ServiceInitializerInterface
{
    /**
     * @param Klein $klein
     *
     * @return callable
     */
    public static function initService(Klein $klein): callable
    {
        return static function () use ($klein) {
            return new Auth($klein->app()->__get('entityManager'));
        };
    }
}
