<?php

namespace App\Repository;

use App\Entity\KanjiVocabulary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<KanjiVocabulary>
 *
 * @method KanjiVocabulary|null find($id, $lockMode = null, $lockVersion = null)
 * @method KanjiVocabulary|null findOneBy(array $criteria, array $orderBy = null)
 * @method KanjiVocabulary[]    findAll()
 * @method KanjiVocabulary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KanjiVocabularyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KanjiVocabulary::class);
    }

    //    /**
    //     * @return KanjiVocabulary[] Returns an array of KanjiVocabulary objects
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

    //    public function findOneBySomeField($value): ?KanjiVocabulary
    //    {
    //        return $this->createQueryBuilder('k')
    //            ->andWhere('k.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
