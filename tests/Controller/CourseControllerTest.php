<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Course;
use App\Tests\Traits\EntityFinderTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CourseControllerTest extends WebTestCase
{
    use EntityFinderTrait;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * testIndex.
     */
    public function testIndex(): void
    {
        $this->client->request('GET', '/cours');

        self::assertResponseIsSuccessful();
    }

    /**
     * testShow.
     */
    public function testShow(): void
    {
        $this->client->request('GET', '/cours/the-course-one');

        self::assertResponseIsSuccessful();
    }

    /**
     * testNotFoundWhenCourseNotPublished.
     */
    public function testNotFoundWhenCourseNotPublished(): void
    {
        $courseNotPublished = $this->findOneEntityBy(Course::class, ['published' => false]);
        $this->client->request('GET', '/cours/'.$courseNotPublished->getSlug());

        self::assertResponseStatusCodeSame(404);
    }

    /**
     * testWhenUserLoggedAndCourseNotPublished.
     */
    public function testWhenUserLoggedAndCourseNotPublished(): void
    {
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $courseNotPublished = $this->findOneEntityBy(Course::class, ['published' => false]);
        $this->client->loginUser($user);
        $this->client->request('GET', '/cours/'.$courseNotPublished->getSlug());

        self::assertResponseIsSuccessful();
    }

    /**
     * testShowAdminLinkWhenUserLogged.
     */
    public function testShowAdminLinkWhenUserLogged(): void
    {
        // User logged
        $user = $this->findOneEntityBy(User::class, ['email' => 'admin@domaine.fr']);
        $this->client->loginUser($user);
        $this->client->request('GET', '/cours/the-course-one');

        $this->assertSelectorTextContains('div.mt-3 a', 'Modifier le cours');
        // $this->assertSelectorTextContains('div.alert.alert-warning', "Ce cours n'est pas encore publié !");

        // User not logged
        $this->client->request('GET', '/cours/the-course-one');

        $this->assertAnySelectorTextContains('div.mt-3 a', 'Modifier le cours');
        // $this->assertAnySelectorTextContains('div.alert.alert-warning', "Ce cours n'est pas encore publié !");
    }
}
