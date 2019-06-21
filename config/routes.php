<?php

return [
    'firewall' => [
        'type'     => ['GET', 'POST'],
        'route'    => '!@\.(css|js)$',
        'callback' => 'App\Controller\FirewallController::filterAction'
    ],
    /** ------------------------------ Login ------------------------------ */
    'register' => [
        'type'     => ['GET', 'POST'],
        'route'    => '/register',
        'callback' => 'App\Controller\RegistrationController::registerAction'
    ],
    'login' => [
        'type'     => ['GET', 'POST'],
        'route'    => '/login',
        'callback' => 'App\Controller\LoginController::loginAction'
    ],
    'logout' => [
        'type'     => ['GET', 'POST'],
        'route'    => '/logout',
        'callback' => 'App\Controller\LoginController::logoutAction'
    ],
    /** ------------------------------ Pages ------------------------------ */
    'todos-page' => [
        'type'     => 'GET',
        'route'    => '/todos',
        'callback' => 'App\Controller\PageController::renderToDoPageAction'
    ],
    'todos-list' => [
        'type'     => 'POST',
        'route'    => '/todos',
        'callback' => 'App\Controller\PageController::renderToDoListAction'
    ],
    /** ------------------------------ Api ------------------------------ */
    'api-todos-cget' => [
        'type'     => 'GET',
        'route'    => '/api/v1/todos',
        'callback' => 'App\Controller\ToDoController::cGetAction'
    ],
    'api-todos-post' => [
        'type'     => 'POST',
        'route'    => '/api/v1/todos',
        'callback' => 'App\Controller\ToDoController::postAction'
    ],
    'api-todos-delete' => [
        'type'     => 'DELETE',
        'route'    => '/api/v1/todos/[i:id]',
        'callback' => 'App\Controller\ToDoController::deleteAction'
    ],
    'api-todos-cdelete' => [
        'type'     => 'DELETE',
        'route'    => '/api/v1/todos',
        'callback' => 'App\Controller\ToDoController::cDeleteAction'
    ],
    'api-todos-put' => [
        'type'     => 'PUT',
        'route'    => '/api/v1/todos/[i:id]',
        'callback' => 'App\Controller\ToDoController::putAction'
    ],
];
