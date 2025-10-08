<?php

namespace App\Tests\Controller\Admin;

use App\Controller\Admin\DashboardController;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use App\Controller\Admin\RegisteredCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class RegisteredCrudControllerTest extends AbstractCrudTestCase
{
    use CrudAuthenticationTestTrait;

    protected function getControllerFqcn(): string
    {
        return RegisteredCrudController::class;
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
        ];
    }
}
