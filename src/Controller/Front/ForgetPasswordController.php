<?php

namespace App\Controller\Front;

use App\Service\Auth\ForgetPasswordService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ForgetPasswordController extends AbstractController
{
    public function __construct(private ForgetPasswordService $forgetPasswordService)
    {
    }

    #[Route('/demande-renouvellement-mot-de-passe', name: 'ask.reset.password', methods: ['GET', 'POST'])]
    public function askResetPassword(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('homepage');
        }

        if ('POST' == $request->getMethod()) {
            /** @var string|null */
            $csrf = $request->request->get('_token');
            if (!$this->isCsrfTokenValid('forget-password', $csrf)) {
                throw new BadRequestHttpException();
            }

            /** @var string */
            $email = $request->request->get('email');
            $user = $this->forgetPasswordService->getUserByEmail($email);

            if (is_null($user)) {
                $this->addFlash('danger', "Aucun email n'existe");

                return $this->redirectToRoute('ask.reset.password');
            }

            if (!is_null($this->forgetPasswordService->exist($user))) {
                $this->addFlash('info', 'Une demande existe déjà pour cette email');

                return $this->redirectToRoute('ask.reset.password');
            }

            try {
                $forgetPassword = $this->forgetPasswordService->persist($user);
                $this->forgetPasswordService->sendEmail($forgetPassword);
                $this->addFlash('success', 'Un email vous a été envoyé');
            } catch (ORMException $e) {
                $this->addFlash('danger', 'Un problème est survenue');
            }

            return $this->redirectToRoute('ask.reset.password');
        }

        return $this->render('front/forget_password/ask-reset-password.html.twig');
    }
}

/*
 * Récupérer l'adresse email
 * On vérifie qu'un utilisateur posséde cette adresse email
 * On vérifie qu'aucune demande existe déjà
 * Enregistrement de la demande
 * Envoie email
 */
