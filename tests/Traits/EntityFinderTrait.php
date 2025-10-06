<?php

namespace App\Tests\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @template T of object
 */
trait EntityFinderTrait
{
    private const VALID_FIELD_PATTERN = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';

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
     *
     * @return T
     *
     * @throws \RuntimeException si l'entité n'existe pas
     */
    protected function findEntityOrFail(string $entityClass, int $id): object
    {
        $entity = $this->findEntity($entityClass, $id);

        if (null === $entity) {
            throw new \RuntimeException(sprintf("L'entité %s avec l'id %d n'existe pas. Vérifiez vos fixtures.", $entityClass, $id));
        }

        return $entity;
    }

    /**
     * @param class-string<T>      $entityClass
     * @param array<string, mixed> $criteria
     *
     * @return T
     *
     * @throws \RuntimeException si l'entité n'existe pas
     */
    protected function findOneEntityByOrFail(string $entityClass, array $criteria): object
    {
        $entity = $this->findOneEntityBy($entityClass, $criteria);

        if (null === $entity) {
            throw new \RuntimeException(sprintf('L\'entité %s avec le critère %s n\'existe pas. Vérifiez vos fixtures.', $entityClass, json_encode($criteria)));
        }

        return $entity;
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
            $this->validateFieldName($field);

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

    private function validateFieldName(string $field): void
    {
        if (!preg_match(self::VALID_FIELD_PATTERN, $field)) {
            throw new \InvalidArgumentException(sprintf('Le champs est invalide: %s', $field));
        }
    }
}
