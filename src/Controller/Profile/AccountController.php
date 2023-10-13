<?php

namespace App\Controller\Profile;

use App\Form\User\EditUserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/profil/mon-compte', name: 'account.profil', methods: ['GET'])]
    public function profil(): Response
    {
        $form = $this->createForm(EditUserProfileType::class, $this->getUser());
        return $this->render('profile/profile.html.twig', [
            'form' => $form,
            'current_page' => 'profile',
        ]);
    }
}
