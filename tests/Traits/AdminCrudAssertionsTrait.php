<?php

namespace App\Tests\Traits;

trait AdminCrudAssertionsTrait
{
    protected function assertEntityCreated(string $entityName): void
    {
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains(
            '.alert.alert-success',
            sprintf("'%s' a été créé avec succès.", $entityName)
        );
    }

    protected function assertEntityUpdated(string $entityName): void
    {
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertSelectorExists('.alert.alert-success');
        $this->assertSelectorTextContains(
            '.alert.alert-success',
            sprintf("'%s' a été mis à jour avec succès.", $entityName)
        );
    }

    protected function assertEntityDeleted(): void
    {
        $this->assertResponseRedirects('/admin');
    }

    protected function assertAccessDeniedForAnonymous(string $url): void
    {
        $this->client->request('GET', $url);
        static::assertResponseRedirects('/connexion');
    }

    protected function assertAccessGrantedForAdmin(string $url): void
    {
        $this->client->request('GET', $url);
        static::assertResponseIsSuccessful();
    }
}
