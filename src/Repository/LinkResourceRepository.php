<?php

namespace App\Repository;

use App\Entity\LinkResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkResource>
 *
 * @method LinkResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkResource[]    findAll()
 * @method LinkResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkResourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkResource::class);
    }

    //    /**
    //     * @return LinkResource[] Returns an array of LinkResource objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?LinkResource
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
