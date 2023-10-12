<?php

namespace App\Tests\Traits;

trait ValidatorTrait
{
    protected function assertHasErrors(object $entity, int $number = 0): void
    {
        $validator = static::getContainer()->get('validator');

        $error = $validator->validate($entity); /* @phpstan-ignore-line */
        $this->assertCount($number, $error);
    }
}
