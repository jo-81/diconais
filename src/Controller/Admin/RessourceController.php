<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Repository\ResourceRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/resources')]
class RessourceController extends AbstractController
{
    public const ITEM_PER_PAGE = 7;

    public function __construct(
        private ResourceRepository $resourceRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('', name: 'admin.ressource.list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('admin/ressource/index.html.twig', [
            'current_page' => 'resource',
            'ressources' => $this->getPaginationResources($request),
        ]);
    }

    #[Route('/{id}', name: 'admin.ressource.single', methods: ['GET'])]
    public function show(Resource $resource): Response
    {
        return $this->render('admin/ressource/show.html.twig', [
            'current_page' => 'resource',
            'ressource' => $resource,
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
