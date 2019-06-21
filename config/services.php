<?php

use App\Service\Initializer\AuthInitializer;
use App\Service\Initializer\EntityManagerInitializer;
use App\Service\Initializer\FormFactoryInitializer;
use App\Service\Initializer\TwigInitializer;

return [
    'entityManager'   => EntityManagerInitializer::class,
    'formFactory'     => FormFactoryInitializer::class,
    'twigEnvironment' => TwigInitializer::class,
    'auth'            => AuthInitializer::class,
];
