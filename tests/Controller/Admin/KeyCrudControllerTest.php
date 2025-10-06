<?php

namespace App\Tests\Controller\Admin;

use App\Entity\Key;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\KeyCrudController;
use App\Controller\Admin\DashboardController;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class KeyCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Key>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;

    protected function getControllerFqcn(): string
    {
        return KeyCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * @return array<int, list<int|string>>
     */
    public static function provideProtectedUrls(): iterable
    {
        return [
            ['index'],
            ['detail', 1],
        ];
    }
}
