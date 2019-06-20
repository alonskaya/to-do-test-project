<?php

namespace App\Service\Initializer;

use Symfony\Component\Form\Forms;

/**
 * Class FormFactoryInitializer
 * @package App\Service\Initializer
 */
class FormFactoryInitializer implements ServiceInitializerInterface
{
    /**
     * @return callable
     */
    public static function initService(): callable
    {
        return static function () {
            return Forms::createFormFactory();
        };
    }
}
