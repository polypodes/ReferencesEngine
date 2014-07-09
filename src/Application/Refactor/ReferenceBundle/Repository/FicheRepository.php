<?php

namespace Application\Refactor\ReferenceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class FicheRepository extends EntityRepository
{
    const QUERY_ALIAS = 'f';

    public function findByIds(Array $ids)
    {
        return $this
            ->buildSeveralByIds($ids)
            ->getQuery()
            ->execute()
        ;
    }

    private function buildSeveralByIds(Array $ids, QueryBuilder $qb = null)
    {
        if (null === $qb) {
            $qb = $this->createQueryBuilder(self::QUERY_ALIAS);
        }
        return $qb
            ->where('f.id IN (:ids)')
            ->setParameter('ids', $ids)
        ;
    }
}
