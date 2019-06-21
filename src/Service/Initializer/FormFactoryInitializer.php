<?php

namespace App\Service\Initializer;

use Klein\Klein;
use Symfony\Component\Form\Forms;

/**
 * Class FormFactoryInitializer
 * @package App\Service\Initializer
 */
class FormFactoryInitializer implements ServiceInitializerInterface
{
    /**
     * @param Klein $klein
     *
     * @return callable
     */
    public static function initService(Klein $klein): callable
    {
        return static function () {
            return Forms::createFormFactory();
        };
    }
}
