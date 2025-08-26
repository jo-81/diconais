<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoryTest extends WebTestCase
{
    use ValidatorTrait;

    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function getValidEntity(): Category
    {
        return (new Category())
            ->setName('a valid category')
            ->setSlug('a-valid-category')
            ->setColor('#4f4f4f')
        ;
    }

    /**
     * testUniqueValuePropertyName.
     */
    public function testUniqueValuePropertyName(): void
    {
        $category = $this->getValidEntity();
        $category->setName('category');
        $violations = $this->getValidationErrors($category, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur est déjà utilisée.', $violations['messages']);
    }

    /**
     * testUniqueValuePropertyName.
     */
    public function testUniqueValuePropertySlug(): void
    {
        $category = $this->getValidEntity();
        $category->setSlug('category');
        $violations = $this->getValidationErrors($category, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains('Cette valeur est déjà utilisée.', $violations['messages']);
    }

    /**
     * testNotValidPropertyColor.
     */
    public function testNotValidPropertyColor(): void
    {
        $category = $this->getValidEntity();
        $category->setColor('color');
        $violations = $this->getValidationErrors($category, $this->validator);

        $this->assertEquals(1, $violations['count']);
        $this->assertContains("Ce format de couleur n'est pas autorisé.", $violations['messages']);
    }

    /**
     * testValidEntity.
     */
    public function testValidEntity(): void
    {
        $violations = $this->getValidationErrors($this->getValidEntity(), $this->validator);

        $this->assertEquals(0, $violations['count']);
    }
}
