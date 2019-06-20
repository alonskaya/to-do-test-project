<?php

return [
    'register' => [
        'type'     => ['GET', 'POST'],
        'route'    => '/register',
        'callback' => 'App\Controller\RegistrationController::action'
    ],
];
