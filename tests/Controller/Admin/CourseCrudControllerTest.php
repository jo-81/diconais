<?php

namespace App\Tests\Controller\Admin;

use App\Entity\User;
use App\Entity\Course;
use App\Tests\Traits\EntityFinderTrait;
use App\Controller\Admin\DashboardController;
use App\Controller\Admin\CourseCrudController;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use EasyCorp\Bundle\EasyAdminBundle\Test\AbstractCrudTestCase;

class CourseCrudControllerTest extends AbstractCrudTestCase
{
    /**
     * @use EntityFinderTrait<Course>
     */
    use EntityFinderTrait;
    use ReloadDatabaseTrait;

    protected function getControllerFqcn(): string
    {
        return CourseCrudController::class;
    }

    protected function getDashboardFqcn(): string
    {
        return DashboardController::class;
    }

    /**
     * testCoursePageWhenUserNotLogged.
     */
    public function testCoursePageWhenUserNotLogged(): void
    {
        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseRedirects('/connexion');

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseRedirects('/connexion');
    }

    /**
     * testCoursePageWhenUserLogged.
     */
    public function testCoursePageWhenUserLogged(): void
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $testUser = $userRepository->findOneByEmail('admin@domaine.fr');
        $this->client->loginUser($testUser);

        $this->client->request('GET', $this->generateIndexUrl());
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateDetailUrl(1));
        static::assertResponseIsSuccessful();

        $this->client->request('GET', $this->generateNewFormUrl());
        static::assertResponseIsSuccessful();
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
        self::assertResponseRedirects();

        $this->client->followRedirect();

        $this->assertSelectorTextContains('div', "'A new course' a été créé avec succès.");
    }
}
