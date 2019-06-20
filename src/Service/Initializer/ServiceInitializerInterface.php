<?php

namespace App\Service\Initializer;

/**
 * Interface ServiceInitializerParserInterface
 * @package App\Service\Initializer
 */
interface ServiceInitializerInterface
{
    /**
     * @return callable
     */
    public static function initService(): callable;
}
