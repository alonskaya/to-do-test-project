<?php

namespace App\Service;

/**
 * Class ProjectPathKeeper
 * @package App\Service
 */
class ProjectPathKeeper
{
    /**
     * @return string
     */
    public static function getRootDirectory(): string
    {
        return __DIR__ . '/../../';
    }

    /**
     * @return string
     */
    public static function getConfigDirectory(): string
    {
        return self::getRootDirectory() . 'config/';
    }

    /**
     * @return string
     */
    public static function getEntitiesDirectory(): string
    {
        return self::getRootDirectory() . 'src/Entity/';
    }

    /**
     * @return string
     */
    public static function getTemplatesDirectory(): string
    {
        return self::getRootDirectory() . 'views/';
    }
}
