<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class FortuneRepository extends EntityRepository
{
    public function createQueryBuilderOrderByAndFilterBy($orderBy = null, $search = null, $extact = false)
    {
        $qb = $this->createQueryBuilder('f');
        if ('votes_desc' == $orderBy) {
            $qb->orderBy('f.votes', 'DESC');
        } elseif ('votes_asc' == $orderBy) {
            $qb->orderBy('f.votes', 'ASC');
        }

        if ($search) {
            $qb->andWhere('f.quotes like :author');
            if ($extact) {
                $qb->setParameter('author', sprintf('<%%%s%%>', $search));
            } else {
                $qb->setParameter('author', sprintf('%%%s%%', $search));
            }
        }

        return $qb->addOrderBy('f.createdAt', 'DESC');
    }

    public function findAllOrderByAndFilterByAsArray($orderBy = null, $search = null, $extact = false)
    {
        $fortunes = $this
            ->createQueryBuilderOrderByAndFilterBy($orderBy, $search, $extact)
            ->getQuery()
            ->getResult()
        ;


        return array_map(function(Fortune $fortune) {
            return array(
                'id' => $fortune->getId(),
                'quotes' => $fortune->getQuotesAsArray(),
                'votes' => $fortune->getVotes(),
                'author' => $fortune->getAuthor(),
                'createdAt' => $fortune->getCreatedAt()->format('c'),
            );
        }, $fortunes);
    }
}
