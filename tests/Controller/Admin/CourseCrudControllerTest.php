<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Course;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\CourseCrudController;
use App\Tests\Traits\AdminCrudAssertionsTrait;
use App\Tests\Traits\CrudAuthenticationTestTrait;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class CourseCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Course>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;
    use CrudAuthenticationTestTrait;
    use AdminCrudAssertionsTrait;

    protected function getControllerFqcn(): string
    {
        return CourseCrudController::class;
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
            ['new'],
            ['detail', 1],
            ['edit', 1],
        ];
    }

    /**
     * testCreateEntityCourse.
     */
    public function testCreateEntityCourse(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateNewFormUrl());

        $form = $crawler->selectButton('Créer')->form();
        $form['Course[name]'] = 'A new course';
        $form['Course[slug]'] = 'a-new-course';
        $form['Course[content]'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce finibus interdum sem laoreet dapibus.';
        $form['Course[category]'] = '1';
        $form['Course[published]'] = '1';
        $this->client->submit($form);

        self::assertInstanceOf(Course::class, $this->findOneEntityBy(Course::class, ['name' => 'A new course']));
        $this->assertEntityCreated('A new course');
    }

    /**
     * testUpdateEntityCourse.
     */
    public function testUpdateEntityCourse(): void
    {
        $testUser = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($testUser);
        $crawler = $this->client->request('GET', $this->generateEditFormUrl(1));

        $form = $crawler->selectButton('Sauvegarder les modifications')->form();
        $form['Course[name]'] = 'Cours modifié';
        $this->client->submit($form);

        $entityUpdate = $this->findEntity(Course::class, 1);

        self::assertInstanceOf(Course::class, $entityUpdate);

        $this->assertEntityUpdated('Cours modifié');
    }
}
