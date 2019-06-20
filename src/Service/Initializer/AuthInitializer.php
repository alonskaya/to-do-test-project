<?php

namespace App\Service\Initializer;

use Symfony\Component\Form\Forms;

/**
 * Class AuthInitializer
 * @package App\Service\Initializer
 */
class AuthInitializer implements ServiceInitializerInterface
{
    /**
     * @return callable
     */
    public static function initService(): callable
    {
        return static function () {
            /*
            $klein->respond('*', function ($request, Response $response, $service, $app) {
/** @var Auth $auth *
            $auth = $app->__get('auth');

            if (!in_array($request->pathName(), ['/login', '/register'])) {
                if (!$auth->user()) {
                    $query = http_build_query(
                        [
                            'referrer' => $request->pathName(),
                        ]
                    );
                    $response->redirect('login?' . $query)->send();
                }
            }
        });
            */
        };
    }
}
