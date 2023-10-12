<?php

namespace App\Controller\Front;

use App\Entity\ForgetPassword;
use App\Entity\User;
use App\Form\User\ResetPasswordType;
use App\Service\Auth\ResetPasswordService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(private ResetPasswordService $resetPasswordService)
    {
    }

    #[Route('/renouvellement-mot-de-passe/{token}', name: 'reset.password')]
    public function resetPassword(ForgetPassword $forgetPassword, Request $request): Response
    {
        $form = $this->createForm(ResetPasswordType::class, $forgetPassword->getPerson());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                if (!$this->resetPasswordService->canEditPassword($forgetPassword)) {
                    $this->resetPasswordService->remove($forgetPassword);
                    $this->addFlash('danger', 'Votre demande de ré initialisation de mot de passe à expiré');

                    return $this->redirectToRoute('ask.reset.password');
                }

                /** @var User */
                $user = $form->getData();
                $this->resetPasswordService->editPassword($user);
                $this->resetPasswordService->remove($forgetPassword);

                return $this->redirectToRoute('app_login');
            } catch (ORMException $e) {
                $this->addFlash('danger', 'Un problème est survenue');

                return $this->redirectToRoute('reset.password', ['token' => $forgetPassword->getToken()]);
            }
        }

        return $this->render('front/reset_password/reset-password.html.twig', [
            'form' => $form,
        ]);
    }
}
