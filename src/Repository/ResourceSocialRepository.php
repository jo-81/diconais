<?php

namespace App\Repository;

use App\Entity\ResourceSocial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResourceSocial>
 *
 * @method ResourceSocial|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceSocial|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceSocial[]    findAll()
 * @method ResourceSocial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceSocialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceSocial::class);
    }

    //    /**
    //     * @return ResourceSocial[] Returns an array of ResourceSocial objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ResourceSocial
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
