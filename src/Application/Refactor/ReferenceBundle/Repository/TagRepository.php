<?php

namespace Application\Refactor\ReferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TagRepository extends EntityRepository
{
    const QUERY_ALIAS = 't';

    public function findAllOrderByTitle()
    {
        return $this
            ->buildOrderByTitle()
            ->getQuery()
            ->execute()
        ;
    }

    private function buildOrderByTitle(QueryBuilder $qb = null)
    {
        if (null === $qb) {
            $qb = $this->createQueryBuilder(self::QUERY_ALIAS);
        }
        return $qb
            ->orderBy(self::QUERY_ALIAS.'.title', 'ASC')
        ;
    }
}
