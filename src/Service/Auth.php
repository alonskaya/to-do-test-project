<?php

namespace App\Authentication;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Jasny\Auth\Confirmation;
use Jasny\Auth\Sessions;
use Jasny\Auth\User as AuthUser;

/**
 * Class Auth
 * @package App\Authentication
 */
class Auth extends \Jasny\Auth
{
    use Sessions;
    use Confirmation;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Auth constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Fetch a user by ID
     *
     * @param int|string $id
     *
     * @return AuthUser|null
     */
    public function fetchUserById($id): ?AuthUser
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    /**
     * Fetch a user by username
     *
     * @param string $username
     *
     * @return User|null
     */
    public function fetchUserByUsername($username): ?AuthUser
    {
        return $this->entityManager->getRepository(User::class)->findOneBy([
            'email' => $username,
        ]);
    }

    /**
     * @return array|false|string
     */
    public function getConfirmationSecret()
    {
        return getenv('APP_SECRET');
    }
}
