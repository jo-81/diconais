<?php

namespace App\Controller\Admin;

use App\Entity\Social;
use App\Form\Social\SocialType;
use App\Repository\SocialRepository;
use App\Service\Social\SocialService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/admin/socials')]
class SocialController extends AbstractController
{
    public const ITEM_PER_PAGE = 7;

    public function __construct(
        private SocialRepository $socialRepository,
        private PaginatorInterface $paginator,
        private SocialService $socialService
    ) {
    }

    #[Route('', name: 'admin.social.list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('admin/social/index.html.twig', [
            'current_page' => 'social',
            'socials' => $this->getPaginationSocials($request),
        ]);
    }

    #[Route('/{id}', name: 'admin.social.show', methods: ['GET'])]
    public function show(Social $social): Response
    {
        return $this->render('admin/social/show.html.twig', [
            'current_page' => 'social',
            'social' => $social,
        ]);
    }

    #[Route('/{id}/remove', name: 'admin.social.remove', methods: ['GET', 'POST'])]
    public function remove(Social $social, Request $request): Response
    {
        if ('POST' == $request->getMethod()) {
            /** @var string|null */
            $csrf = $request->request->get('_token');
            if (!$this->isCsrfTokenValid('admin-social-remove', $csrf)) {
                throw new BadRequestHttpException("Le jeton CSRF n'est pas valide");
            }

            $this->socialService->remove($social);
            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                return $this->render('admin/social/parts/_template-remove-social.html.twig', [
                    'socials' => $this->getPaginationSocials($request),
                ]);
            }

            return $this->redirectToRoute('admin.social.list');
        }

        return $this->render('admin/social/remove.html.twig', [
            'current_page' => 'social',
            'social' => $social,
        ]);
    }

    #[Route('/add', name: 'admin.social.add', methods: ['GET', 'POST'], priority: 10)]
    public function add(Request $request): Response
    {
        $social = new Social();
        $form = $this->createForm(SocialType::class, $social, [
            'action' => $this->generateUrl('admin.social.add'),
        ]);
        $formCloned = clone $form;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Social */
            $social = $form->getData();
            $this->socialService->persist($social);

            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                return $this->render('admin/social/parts/_template-add-social.html.twig', [
                    'socials' => $this->getPaginationSocials($request),
                    'form' => $formCloned,
                ]);
            }

            return $this->redirectToRoute('admin.social.list');
        }

        return $this->render('admin/social/add.html.twig', [
            'current_page' => 'social',
            'form' => $form,
        ]);
    }

    private function getPaginationSocials(Request $request): PaginationInterface /* @phpstan-ignore-line */
    {
        return $this->paginator->paginate(
            $this->socialRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            self::ITEM_PER_PAGE
        );
    }
}
