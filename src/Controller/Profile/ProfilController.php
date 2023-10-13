<?php

namespace App\Controller\Profile;

use App\Form\User\EditUserProfileType;
use App\Form\User\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('', name: 'user.profil', methods: ['GET', 'POST'])]
    public function profil(): Response
    {
        $form = $this->createForm(EditUserProfileType::class, $this->getUser());

        return $this->render('profile/profile.html.twig', [
            'form' => $form,
            'current_page' => 'profile',
        ]);
    }

    #[Route('/edit-password', name: 'edit.password.profil', methods: ['GET', 'POST'])]
    public function editPassword(): Response
    {
        $form = $this->createForm(ResetPasswordType::class, $this->getUser());

        return $this->render('profile/edit-password.html.twig', [
            'form' => $form,
            'current_page' => 'edit-password',
        ]);
    }
}
