<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FortuneRepository extends EntityRepository
{
    public function createQueryBuilderOrderByAndFilterBy($orderBy = null, $search = null)
    {
        $qb =  $this->createQueryBuilder('f');
        if ('votes_desc' == $orderBy) {
            $qb->orderBy('f.votes', 'DESC');
        } elseif ('votes_asc' == $orderBy) {
            $qb->orderBy('f.votes', 'ASC');
        }

        if ($search) {
            $qb
                ->andWhere('f.quotes like :author')
                ->setParameter('author', sprintf('%%%s%%', $search))
            ;
        }

        return $qb->addOrderBy('f.createdAt', 'DESC');
    }
}
