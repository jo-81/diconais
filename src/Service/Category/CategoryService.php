<?php

namespace App\Service\Category;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryService
{
    public function __construct(private EntityManagerInterface $em, private SluggerInterface $sluggerInterface)
    {
    }

    public function persist(Category $category): void
    {
        $slug = $this->sluggerInterface->slug($category->getName())->lower(); /* @phpstan-ignore-line */
        $category->setSlug($slug);

        $this->em->persist($category);
        $this->em->flush();
    }
}
