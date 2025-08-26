<?php

namespace App\Tests\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @template T of object
 */
trait EntityFinderTrait
{
    /**
     * @param class-string<T> $entityClass
     *
     * @return T|null
     */
    protected function findEntity(string $entityClass, int $id): ?object
    {
        return $this->getEntityManager()->find($entityClass, $id);
    }

    /**
     * @param class-string<T> $entityClass
     * @param array<mixed>    $criteria
     *
     * @return T|null
     */
    protected function findOneEntityBy(string $entityClass, array $criteria): ?object
    {
        return $this->getEntityManager()->getRepository($entityClass)->findOneBy($criteria);
    }

    /**
     * @param class-string<T> $entityClass
     *
     * @return T[]
     */
    protected function findAllEntities(string $entityClass): array
    {
        return $this->getEntityManager()->getRepository($entityClass)->findAll();
    }

    /**
     * @param class-string<T> $entityClass
     * @param array<mixed>    $criteria
     */
    protected function countEntities(string $entityClass, array $criteria = []): int
    {
        $repository = $this->getEntityManager()->getRepository($entityClass);
        $qb = $repository->createQueryBuilder('e');

        foreach ($criteria as $field => $value) {
            $qb->andWhere("e.$field = :$field")
                ->setParameter($field, $value);
        }

        return (int) $qb->select('COUNT(e.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Récupère l'EntityManager.
     */
    protected function getEntityManager(): EntityManagerInterface
    {
        if (method_exists($this, 'getContainer')) {
            return $this->getContainer()->get('doctrine')->getManager(); /* @phpstan-ignore-line */
        } elseif (property_exists($this, 'kernel') && $this->kernel instanceof KernelInterface) { /* @phpstan-ignore-line */
            return $this->kernel->getContainer()->get('doctrine')->getManager(); /* @phpstan-ignore-line */
        } elseif (method_exists($this, 'getClient') && $this->getClient()) {
            return $this->getClient()->getContainer()->get('doctrine')->getManager(); /* @phpstan-ignore-line */
        }

        throw new \LogicException('Impossible de récupérer l\'EntityManager. Assurez-vous que ce trait est utilisé dans une classe qui étend KernelTestCase ou WebTestCase.');
    }
}
