<?php

namespace App\Service\Media;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;

class ImageService
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function removeEntity(Image $image): void
    {
        $this->em->remove($image);
        $this->em->flush();
    }
}