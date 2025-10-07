<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use App\Entity\Category;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CourseTest extends WebTestCase
{
    use ReloadDatabaseTrait;
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Course
    {
        return (new Course())
            ->setName('A course for test')
            ->setSlug('a-course-for-test')
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis fermentum, nisi sit amet aliquam convallis, ante nunc hendrerit nibh, sed aliquet quam velit quis erat.')
            ->setCategory(new Category())
        ;
    }

    /**
     * testValidEntity.
     */
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
        $course->setName('The course one');
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
        $course->setSlug('the-course-one');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur est déjà utilisée.', $violations['messages']);
    }

    public function testValuePropertyContent(): void
    {
        $course = $this->getValidEntity();
        $course->setContent('');
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(2, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être vide.', $violations['messages']);
        $this->assertContains('Le contenu doit contenir au moins 10 caractères.', $violations['messages']);
    }

    /**
     * testValuePropertyCategory.
     */
    public function testValuePropertyCategory(): void
    {
        $course = $this->getValidEntity();
        $course->setCategory(null);
        $violations = $this->getValidationErrors($course, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Ce champ ne peut pas être null.', $violations['messages']);
    }
}
