<?php

namespace App\Controller;

use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;

/**
 * Class FirewallController
 * @package App\Controller
 */
class FirewallController
{
    /**
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     */
    public static function filterAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        $auth = $app->__get('auth');

        /** TODO: make auth config */
        if (!in_array($request->pathName(), ['/login', '/register'])) {
            if (!$auth->user()) {
                $query = http_build_query(['referrer' => $request->pathName()]);

                $response->redirect('login?' . $query)->send();
            }
        }
    }
}
