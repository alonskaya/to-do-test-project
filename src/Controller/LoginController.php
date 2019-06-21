<?php

namespace App\Controller;

use App\Form\LoginType;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Symfony\Component\Form\FormFactory;
use Twig\Environment;
use App\Service\Auth;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController
{
    /**
     * TODO: handle exceptions
     * TODO: show error validation messages
     *
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     *
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public static function loginAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var FormFactory $formFactory */
        $formFactory = $app->__get('formFactory');
        /** @var Environment $twig */
        $twig        = $app->__get('twigEnvironment');
        /** @var Auth $auth */
        $auth        = $app->__get('auth');

        $form = $formFactory->create(LoginType::class);

        if ($formData = $request->paramsPost()->get('login')) {
            $form->submit($formData);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($auth->login($formData['_username'], $formData['_password'])) {
                    if ($referrer = $request->paramsGet()->get('referrer')) {
                        $response->redirect($referrer)->send();
                    }
                }
            }
        }

        if ($auth->user()) {
            $response->redirect('todos')->send();
        }

        $view = $twig->render('login_registration/login.html.twig', [
            'form' => $form->createView(),
        ]);

        $response->body($view);

        return $response;
    }

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     */
    public static function logoutAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        session_destroy();

        $response->redirect('login')->send();
    }
}
