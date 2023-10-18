<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Tests\Traits\ValidatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    use ValidatorTrait;

    public function getCategory(): Category
    {
        return (new Category())
            ->setName('une catégorie')
            ->setColor('#000000')
        ;
    }

    public function testBadName(): void
    {
        $category = $this->getCategory();

        $category->setName('u');
        $this->assertHasErrors($category, 1);
    }

    public function testUniqueName(): void
    {
        $category = $this->getCategory();

        $category->setName('category');
        $this->assertHasErrors($category, 1);
    }

    public function testBadColor(): void
    {
        $category = $this->getCategory();

        $category->setColor('uferf');
        $this->assertHasErrors($category, 1);
    }

    public function testGoodCategory(): void
    {
        $this->assertHasErrors($this->getCategory(), 0);
    }
}
