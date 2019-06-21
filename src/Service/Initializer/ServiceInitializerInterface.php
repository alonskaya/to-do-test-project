<?php

namespace App\Service\Initializer;

use Klein\Klein;

/**
 * Interface ServiceInitializerParserInterface
 * @package App\Service\Initializer
 */
interface ServiceInitializerInterface
{
    /**
     * @param Klein $klein
     *
     * @return callable
     */
    public static function initService(Klein $klein): callable;
}
