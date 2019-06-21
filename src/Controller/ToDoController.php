<?php

namespace App\Controller;

use App\Service\Auth;
use App\Entity\ToDoList;
use App\Form\ToDoType;
use Doctrine\ORM\EntityManager;
use Klein\App;
use Klein\Request;
use Klein\Response;
use Klein\ServiceProvider;
use Symfony\Component\Form\FormFactory;

/**
 * Class ToDoController
 * @package App\Controller
 */
class ToDoController
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
    public static function cGetAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var Auth $auth */
        $auth          = $app->__get('auth');
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');

        $todos = $entityManager->getRepository(ToDoList::class)->findBy(
            [
                'author' => $auth->user(),
            ]
        );

        return $response->json($todos);
    }

    /**
     * Creates a new ToDoList entity.
     *
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     *
     * @return
     */
    public static function postAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var FormFactory $formFactory */
        $formFactory   = $app->__get('formFactory');
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');
        /** @var Auth $auth */
        $auth          = $app->__get('auth');

        $toDo = new ToDoList();
        $form = $formFactory->create(ToDoType::class, $toDo);

        if ($formData = $request->body()) {
            $formData = json_decode($formData, true);

            $form->submit($formData);

            if ($form->isSubmitted() && $form->isValid()) {
                $toDo->setAuthor($auth->user());

                $entityManager->persist($toDo);
                $entityManager->flush();

                return $response->json(json_encode(['status' => 'ok']));
            }
        }
    }

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function deleteAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');

        if ($data = $request->body()) {
            $toDo = $entityManager->getRepository(ToDoList::class)->find(
                $request->param('id')
            );

            $entityManager->remove($toDo);
            $entityManager->flush();

            return $response->json(json_encode(['status' => 'ok']));
        }
    }

    /**
     * @param Request         $request
     * @param Response        $response
     * @param ServiceProvider $service
     * @param App             $app
     *
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public static function putAction(Request $request, Response $response, ServiceProvider $service, App $app)
    {
        /** @var FormFactory $formFactory */
        $formFactory   = $app->__get('formFactory');
        /** @var EntityManager $entityManager */
        $entityManager = $app->__get('entityManager');

        $toDo = $entityManager->getRepository(ToDoList::class)->find(
            $request->param('id')
        );
        $form = $formFactory->create(ToDoType::class, $toDo);

        $form->submit(json_decode($request->body(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $response->json(json_encode(['status' => 'ok']));
        }
    }
}
