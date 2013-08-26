<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FortuneRepository extends EntityRepository
{
    public function createQueryBuilderFilterBy($orderBy = null, $limit = 10)
    {
        $qb =  $this->createQueryBuilder('f');
        if ('votes_desc' == $orderBy) {
            $qb->orderBy('f.votes', 'DESC');
        } elseif ('votes_asc' == $orderBy) {
            $qb->orderBy('f.votes', 'ASC');
        }

        return $qb
            ->addOrderBy('f.createdAt', 'DESC')
            ->setMaxResults($limit)
        ;
    }
}
