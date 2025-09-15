<?php

namespace App\Repository;

use App\Entity\Key;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Key>
 */
class KeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Key::class);
    }

    /**
     * findKeyBy.
     *
     * @return Key[]
     */
    public function findKeyBy(
        string $signification = '',
        string $ideogramme = '',
        ?int $numberKey = null,
        array $strokes = [],
    ) {
        $qb = $this->createQueryBuilder('k')
            ->orderBy('k.number', 'ASC')
        ;

        if (!empty($signification)) {
            $qb
                ->andWhere('k.signification LIKE :signification')
                ->setParameter('signification', '%'.$signification.'%')
            ;
        }

        if (!empty($ideogramme)) {
            $qb
                ->andWhere('k.ideogramme = :ideogramme')
                ->setParameter('ideogramme', $ideogramme)
            ;
        }

        if (!empty($numberKey)) {
            $qb
                ->andWhere('k.number = :number')
                ->setParameter('number', $numberKey)
            ;
        }

        if (isset($strokes['numberStroke']) && !is_null($strokes['numberStroke'])) {
            $egal = $strokes['egal'] ?: '=';

            $qb
                ->andWhere("k.numberStroke $egal :numberStroke")
                ->setParameter('numberStroke', $strokes['numberStroke'])
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Key[] Returns an array of Key objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('k.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Key
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
