<?php

namespace App\Controller;

use App\Entity\ToDoList;
use App\Service\Auth;
use Doctrine\ORM\EntityManager;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Twig\Environment;

/**
 * Class PageController
 * @package App\Controller
 */
class PageController
{
    /**
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
    public static function renderToDoPageAction(
        Request $request,
        Response $response,
        ServiceProvider $service,
        App $app
    ) {
        /** @var Environment $twig */
        $twig = $app->__get('twigEnvironment');
        /** @var Auth $auth */
        $auth = $app->__get('auth');

        $author = $auth->user();
        $view   = $twig->render('page/to_do_page.html.twig', ['user'  => $author]);

        $response->body($view);

        return $response;
    }

    /**
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
    public static function renderToDoListAction(
        Request $request,
        Response $response,
        ServiceProvider $service,
        App $app
    ) {
        /** @var Environment $twig */
        $twig          = $app->__get('twigEnvironment');
        /** @var Auth $auth */
        $auth          = $app->__get('auth');
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');

        $todos = $entityManager->getRepository(ToDoList::class)->findBy(
            [
                'author' => $auth->user(),
            ]
        );

        $view = $twig->render('page/to_do.html.twig', [
            'todos' => $todos,
        ]);

        $response->body($view);

        return $response;
    }
}
