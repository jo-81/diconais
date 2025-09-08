<?php

namespace App\Repository;

use App\Entity\Kana;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Kana>
 */
class KanaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kana::class);
    }

    /**
     * filterListKana.
     *
     * @return Kana[]
     */
    public function filterListKana(string $query, string $type = '', string $accent = '', string $combination = '')
    {
        $qb = $this->createQueryBuilder('k')
            ->orderBy('k.position', 'ASC')
        ;

        if (!empty($query)) {
            $qb
                ->andWhere('k.romaji LIKE :query')
                ->setParameter('query', '%'.$query.'%')
            ;
        }

        if (!empty($type)) {
            $qb
                ->andWhere('k.type = :type')
                ->setParameter('type', $type)
            ;
        }

        if ('' !== $accent) {
            $qb
                ->andWhere('k.accent = :accent')
                ->setParameter('accent', (bool) $accent)
            ;
        }

        if ('' !== $combination) {
            $qb
                ->andWhere('k.combination = :combination')
                ->setParameter('combination', (bool) $combination)
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
