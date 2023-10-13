<?php

namespace App\Controller\Profile;

use App\Form\User\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    #[Route('/profil/mot-de-passe', name: 'password.profil', methods: ['GET'])]
    public function editPassword(): Response
    {
        $form = $this->createForm(ResetPasswordType::class, $this->getUser());

        return $this->render('profile/edit-password.html.twig', [
            'form' => $form,
            'current_page' => 'edit-password',
        ]);
    }
}
