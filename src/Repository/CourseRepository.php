<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Course;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Course>
 */
class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findCourseQuery(string $query, ?Category $category = null)
    {
        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.published = :published')
            ->setParameter('published', true)
            ->orderBy('c.createdAt', 'DESC')
        ;

        if (!empty($query)) {
            $qb
                ->andWhere('c.name LIKE :query')
                ->setParameter('query', '%'.$query.'%')
            ;
        }

        if (!is_null($category)) {
            $qb
                ->andWhere('c.category = :category')
                ->setParameter('category', $category)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Course[] Returns an array of Course objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Course
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
