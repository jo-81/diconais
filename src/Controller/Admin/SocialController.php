<?php

namespace App\Controller\Admin;

use App\Entity\Social;
use App\Repository\SocialRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/socials')]
class SocialController extends AbstractController
{
    public const ITEM_PER_PAGE = 7;

    public function __construct(
        private SocialRepository $socialRepository,
        private PaginatorInterface $paginator
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

    private function getPaginationSocials(Request $request): PaginationInterface /* @phpstan-ignore-line */
    {
        return $this->paginator->paginate(
            $this->socialRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            self::ITEM_PER_PAGE
        );
    }
}
