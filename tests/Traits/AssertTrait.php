<?php

namespace App\Tests\Traits;

trait AssertTrait
{
    protected function assertSuccessMessageWhenCreateEntity(string $entityName): void
    {
        $this->assertSuccessMessage($entityName, 'a été créé avec succès.');
    }

    protected function assertSuccessMessageWhenUpdateEntity(string $entityName): void
    {
        $this->assertSuccessMessage($entityName, 'a été mis à jour avec succès.');
    }

    private function assertSuccessMessage(string $entityName, string $message): void
    {
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains(
            '.alert.alert-success',
            sprintf("'%s' %s", $entityName, $message)
        );
    }
}
