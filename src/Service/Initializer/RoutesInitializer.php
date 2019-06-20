<?php

namespace App\Service\Initializer;

use App\Service\ProjectPathKeeper;
use Klein\Klein;

/**
 * Class RoutesInitializer
 * @package App\Service\Initializer
 */
class RoutesInitializer
{
    /**
     * @param Klein $klein
     *
     * @return mixed
     */
    public static function init(Klein $klein)
    {
        $routes = (include ProjectPathKeeper::getConfigDirectory() . 'routes.php');

        foreach ($routes as $route => $config) {
            $klein->respond($config['type'], $config['route'], $config['callback']);
        }
    }
}
