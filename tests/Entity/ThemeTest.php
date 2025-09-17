<?php

namespace App\Tests\Entity;

use App\Entity\Theme;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ThemeTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Theme
    {
        return (new Theme())
            ->setName('a new theme')
            ->setSlug('a-new-theme')
            ->setDescription('a description')
        ;
    }

    public function testValidEntity(): void
    {
        $violations = $this->getValidationErrors($this->getValidEntity(), $this->validator);

        $this->assertEquals(0, $violations['count']);
    }

    /**
     * testUniqueValuePropertyName.
     */
    public function testUniqueValuePropertyName(): void
    {
        $course = $this->getValidEntity();
        $course->setName('theme');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur est déjà utilisée.', $violations['messages']);
    }

    /**
     * testUniqueValuePropertySlug.
     */
    public function testUniqueValuePropertySlug(): void
    {
        $course = $this->getValidEntity();
        $course->setSlug('theme');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur est déjà utilisée.', $violations['messages']);
    }
}
