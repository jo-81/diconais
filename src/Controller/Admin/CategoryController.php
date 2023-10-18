<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\Category\CategoryType;
use App\Repository\CategoryRepository;
use App\Service\Category\CategoryService;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/admin/categories')]
#[IsGranted('ROLE_ADMIN')]
class CategoryController extends AbstractController
{
    public const ITEM_PER_PAGE = 7;

    public function __construct(
        private CategoryService $categoryService,
        private CategoryRepository $categoryRepository,
        private PaginatorInterface $paginator
    ) {
    }

    #[Route('', name: 'admin.category.list', methods: ['GET'])]
    public function categories(Request $request): Response
    {
        return $this->render('admin/category/categories.html.twig', [
            'current_page' => 'category',
            'categories' => $this->getPaginationCategories($request),
        ]);
    }

    #[Route('/{id}', name: 'admin.category.single', methods: ['GET'])]
    public function category(Category $category): Response
    {
        return $this->render('admin/category/category.html.twig', [
            'current_page' => 'category',
            'category' => $category,
        ]);
    }

    #[Route('/add', name: 'admin.category.add', methods: ['GET', 'POST'], priority: 10)]
    public function add(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('admin.category.add'),
        ]);
        $formCloned = clone $form;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Category */
            $category = $form->getData();
            $this->categoryService->persist($category);

            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                return $this->render('admin/category/parts/_list-categories.html.twig', [
                    'categories' => $this->getPaginationCategories($request),
                    'form' => $formCloned,
                ]);
            }

            return $this->redirectToRoute('admin.category.list');
        }

        return $this->render('admin/category/add.html.twig', [
            'current_page' => 'category',
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin.category.edit', methods: ['GET', 'POST'])]
    public function edit(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('admin.category.edit', ['id' => $category->getId()]),
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Category */
            $category = $form->getData();
            $this->categoryService->persist($category);

            if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
                $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

                return $this->render('admin/category/edit/_template-edit.html.twig', [
                    'category' => $category,
                ]);
            }

            return $this->redirectToRoute('admin.category.single', ['id' => $category->getId()]);
        }

        return $this->render('admin/category/edit/edit.html.twig', [
            'current_page' => 'category',
            'category' => $category,
            'form' => $form,
        ]);
    }

    private function getPaginationCategories(Request $request): PaginationInterface /* @phpstan-ignore-line */
    {
        return $this->paginator->paginate(
            $this->categoryRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1),
            self::ITEM_PER_PAGE
        );
    }
}
