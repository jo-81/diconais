<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Category;
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

    /**
     * findCourseQuery.
     *
     * @return Course[]
     */
    public function findCourseQuery(string $query, ?Category $category = null): array
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

    public function findPublishedWithCategory(int $limit): array
    {
        return $this->createQueryBuilder('c')
            ->select('c', 'cat')
            ->innerJoin('c.category', 'cat')
            ->where('c.published = :published')
            ->setParameter('published', true)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
