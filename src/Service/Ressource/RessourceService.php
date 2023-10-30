<?php

namespace App\Service\Ressource;

use App\Entity\Resource;
use App\Entity\ResourceSocial;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\String\Slugger\SluggerInterface;

class RessourceService
{
    public function __construct(private EntityManagerInterface $em, private SluggerInterface $sluggerInterface)
    {
    }

    public function persist(Resource $ressource): void
    {
        $this->em->beginTransaction();

        $slug = $this->sluggerInterface->slug($ressource->getName())->lower(); /* @phpstan-ignore-line */
        $ressource->setSlug($slug);

        try {
            $this->em->persist($ressource);
            $this->em->flush();

            $this->mergeSocials($ressource);

            $this->em->commit();
        } catch (ORMException $e) {
            $this->em->rollback();
        }
    }

    public function mergeSocials(Resource $ressource): void
    {
        foreach ($ressource->getPlainSocials() as $social) {
            $social->setResource($ressource); /** @phpstan-ignore-line */
            $this->em->persist($social); /** @phpstan-ignore-line */
        }
        $this->em->flush();
    }
}
