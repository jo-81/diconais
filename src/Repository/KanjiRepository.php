<?php

namespace App\Repository;

use App\Entity\Kanji;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Kanji>
 */
class KanjiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kanji::class);
    }

    /**
     * findKanjiBy.
     *
     * @return Kanji[]
     */
    public function findKanjiBy(
        string $signification = '',
        string $ideogramme = '',
        string $jlpt = '',
        array $strokes = [],
    ) {
        $qb = $this->createQueryBuilder('k')
            ->orderBy('k.id', 'DESC')
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

        if (!empty($jlpt)) {
            $qb
                ->andWhere('k.level = :level')
                ->setParameter('level', $jlpt)
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
    //     * @return Kanji[] Returns an array of Kanji objects
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

    //    public function findOneBySomeField($value): ?Kanji
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
