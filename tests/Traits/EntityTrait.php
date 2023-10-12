<?php

namespace App\Tests\Traits;

trait EntityTrait
{
    /**
     * getEntity.
     *
     * @param array<string, mixed> $criteria
     */
    public function getEntity(array $criteria, string $repository): ?object
    {
        $entityRepository = static::getContainer()->get($repository);

        return $entityRepository->findOneBy($criteria); /* @phpstan-ignore-line */
    }
}
