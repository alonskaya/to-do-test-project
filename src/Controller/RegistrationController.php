<?php

namespace App\Controller;

use App\Authentication\Auth;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Form\Forms;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController
{
    public static function action(Request $request, Response $response, ServiceProvider $service, App $app)
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

                $response->body(123);

                return $response;
            }
        }

        $view = $twig->render('login_registration/registration.html.twig', [
            'form' => $form->createView()
        ]);

        $response->body($view);

        return $response;
    }
}
