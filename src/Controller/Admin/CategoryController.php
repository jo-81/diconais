<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'admin.category.list')]
    public function categories(
        PaginatorInterface $paginator,
        Request $request,
        CategoryRepository $categoryRepository
    ): Response {
        $categories = $paginator->paginate(
            $categoryRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/category/categories.html.twig', [
            'current_page' => 'category',
            'categories' => $categories,
        ]);
    }
}
