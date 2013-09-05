<?php

namespace Lyrixx\Bundle\FortuneBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FortuneRepository extends EntityRepository
{
    public function createQueryWithSearch(Search $search)
    {
        $qb = $this->createQueryBuilder('f');
        if ('votes_desc' == $search->orderBy()) {
            $qb->orderBy('f.votes', 'DESC');
        } elseif ('votes_asc' == $search->orderBy()) {
            $qb->orderBy('f.votes', 'ASC');
        }

        if ($search->search()) {
            $qb->andWhere('f.quotes like :author');
            if ($search->exactMatching()) {
                $qb->setParameter('author', sprintf('%%<%s>%%', $search->search()));
            } else {
                $qb->setParameter('author', sprintf('%%%s%%', $search->search()));
            }
        }

        return $qb->addOrderBy('f.createdAt', 'DESC');
    }

    public function findAll()
    {
        $fortunes = $this
            ->createQueryWithSearch(new Search())
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
