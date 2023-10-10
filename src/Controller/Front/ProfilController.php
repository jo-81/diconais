<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil', methods: ['GET'])]
    public function profil(): Response
    {
        return $this->render('front/profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }
}
