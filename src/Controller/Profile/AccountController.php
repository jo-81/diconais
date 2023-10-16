<?php

namespace App\Controller\Profile;

use App\Entity\User;
use App\Form\User\EditUserProfileType;
use App\Service\Profil\AccountService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED')]
class AccountController extends AbstractController
{
    public function __construct(private AccountService $accountService)
    {
    }

    #[Route('/profil/mon-compte', name: 'account.profil', methods: ['GET', 'POST'])]
    public function profil(Request $request): Response
    {
        $form = $this->createForm(EditUserProfileType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $request->request->all('edit_user_profile');
            $csrf = $datas['_token'] ?? null;
            if (!$this->isCsrfTokenValid('edit_user', $csrf)) {
                throw new BadRequestHttpException("Le jeton CSRF n'est pas valide");
            }

            /** @var User */
            $user = $form->getData();

            try {
                $this->accountService->edit($user);
                return $this->redirectToRoute('account.profil');
            } catch (ORMException $e) {
                $this->addFlash('danger', 'Une erreur est survenue');
            }
        }

        return $this->render('profile/account.html.twig', [
            'form' => $form,
            'current_page' => 'profile',
        ]);
    }
}
