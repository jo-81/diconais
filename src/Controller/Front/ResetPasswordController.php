<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/reouvellement-mot-de-passe/{token}', name: 'reset.password')]
    public function index(): Response
    {
        return $this->render('front/reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
