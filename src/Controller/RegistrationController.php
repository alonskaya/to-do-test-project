<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Auth;
use Doctrine\ORM\EntityManager;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Symfony\Component\Form\FormFactory;
use Twig\Environment;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController
{
    /**
     * TODO: handle exceptions
     * TODO: make UserService to use it in another request entry points
     * TODO: show error validation messages
     * TODO: add email confirmation
     *
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public static function registerAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var FormFactory $formFactory */
        $formFactory   = $app->__get('formFactory');
        /** @var Environment $twig */
        $twig          = $app->__get('twigEnvironment');
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');
        /** @var Auth $auth */
        $auth          = $app->__get('auth');

        $user = new User();
        $form = $formFactory->create(UserType::class, $user);

        if ($formData = $request->paramsPost()->get('user')) {
            $form->submit($formData);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = $auth->hashPassword($user->getPlainPassword());

                $user->setPassword($password);

                $entityManager->persist($user);
                $entityManager->flush();

                $response->redirect('/login')->send();
            }
        }

        $view = $twig->render('login_registration/registration.html.twig', [
            'form' => $form->createView()
        ]);

        $response->body($view);

        return $response;
    }
}
