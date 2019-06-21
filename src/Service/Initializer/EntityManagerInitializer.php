<?php

namespace App\Service\Initializer;

use App\Service\ProjectPathKeeper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Klein\Klein;

/**
 * Class EntityManagerInitializer
 * @package App\Service\Initializer
 */
class EntityManagerInitializer implements ServiceInitializerInterface
{
    /**
     * @param Klein $klein
     *
     * @return callable
     */
    public static function initService(Klein $klein): callable
    {
        return static function () {
            $config = Setup::createAnnotationMetadataConfiguration(
                [ProjectPathKeeper::getEntitiesDirectory()],
                isset($_ENV['ENV']) && $_ENV['ENV'] === 'dev',
                null,
                null,
                false
            );

            $connectionParams = (include ProjectPathKeeper::getConfigDirectory() . 'database.php');

            return EntityManager::create($connectionParams, $config);
        };
    }
}
