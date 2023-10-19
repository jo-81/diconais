<?php

namespace App\Controller\Profile;

use App\Entity\Image;
use App\Entity\User;
use App\Form\User\AvatarType;
use App\Service\Profil\AccountService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED')]
class AvatarController extends AbstractController
{
    public function __construct(private AccountService $accountService)
    {
    }

    #[Route('/profil/avatar', name: 'avatar.profil', methods: ['GET', 'POST'])]
    public function avatar(Request $request): Response
    {
        $image = new Image();
        /** @var User */
        $user = $this->getUser();

        $form = $this->createForm(AvatarType::class, $image, [
            'action' => $this->generateUrl('avatar.profil'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Image */
            $image = $form->getData();
            $user->setAvatar($image);
            $this->accountService->edit($user);

            return $this->redirectToRoute('account.profil');
        }

        return $this->render('profile/avatar.html.twig', [
            'form' => $form,
            'formTarget' => $request->headers->get('Turbo-Frame', '_top'),
        ]);
    }
}
