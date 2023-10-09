<?php

namespace App\Repository;

use App\Entity\Kanji;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Kanji>
 *
 * @method Kanji|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kanji|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kanji[]    findAll()
 * @method Kanji[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanjiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kanji::class);
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
