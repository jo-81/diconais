<?php

namespace App\Controller\Front;

use App\Entity\Resource;
use App\Repository\ResourceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RessourceController extends AbstractController
{
    public const ITEM_PER_PAGE = 3;

    public function __construct(
        private ResourceRepository $resourceRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('/sources', name: 'ressource.list', methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('front/ressource/index.html.twig', [
            'resources' => $this->getPaginationResources($request),
        ]);
    }

    #[Route('/sources/{slug}', name: 'ressource.single', methods: ['GET'])]
    public function show(Resource $resource): Response
    {
        if (! $resource->isPublished()) {
            throw $this->createNotFoundException();
        }

        return $this->render('front/ressource/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    private function getPaginationResources(Request $request): PaginationInterface /* @phpstan-ignore-line */
    {
        return $this->paginator->paginate(
            $this->resourceRepository->findBy(['published' => true], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            self::ITEM_PER_PAGE
        );
    }
}
