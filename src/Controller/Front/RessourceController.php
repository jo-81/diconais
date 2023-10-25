<?php

namespace App\Controller\Front;

use App\Repository\ResourceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RessourceController extends AbstractController
{
    public const ITEM_PER_PAGE = 3;

    public function __construct(
        private ResourceRepository $resourceRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/sources', name: 'ressource.list')]
    public function index(Request $request): Response
    {
        return $this->render('front/ressource/index.html.twig', [
            'resources' => $this->getPaginationResources($request),
        ]);
    }

    private function getPaginationResources(Request $request): PaginationInterface /* @phpstan-ignore-line */
    {
        return $this->paginator->paginate(
            $this->resourceRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            self::ITEM_PER_PAGE
        );
    }
}
