<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\User\ResetPasswordType;
use App\Service\Auth\ResetPasswordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED')]
class PasswordController extends AbstractController
{
    public function __construct(private ResetPasswordService $resetPasswordService)
    {
    }

    #[Route('/profil/mot-de-passe', name: 'password.profil', methods: ['GET', 'POST'])]
    public function editPassword(Request $request): Response
    {
        $form = $this->createForm(ResetPasswordType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User */
            $user = $form->getData();
            $this->resetPasswordService->editPassword($user);

            return $this->redirectToRoute('password.profil');
        }

        return $this->render('profile/edit-password.html.twig', [
            'form' => $form,
            'current_page' => 'edit-password',
        ]);
    }
}

// Azerty2000
