<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ToDoListRepository
 * @package App\Repository
 */
class ToDoListRepository extends EntityRepository
{
    /**
     * @param array  $findCriteria
     * @param string $field
     * @param string $order
     *
     * @return array
     */
    public function findByWithOrder(array $findCriteria = [], string $field = 'id', string $order = 'ASC'): array
    {
        return $this->createQueryBuilder('t')
            ->where($findCriteria)
            ->orderBy($field . ' ' . $order)
            ->getQuery()
            ->getResult();
    }
}
