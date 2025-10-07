<?php

namespace App\Twig\Components\Course;

use App\Entity\Category;
use App\Repository\CourseRepository;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Traits\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsLiveComponent]
final class CourseList
{
    use DefaultActionTrait;
    use PaginationTrait;

    #[LiveProp(writable: true, url: true)]
    public string $categorySlug = '';

    #[LiveProp(writable: true, url: true)]
    public string $query = '';

    public function __construct(
        private CourseRepository $courseRepository,
        private PaginatorInterface $paginator,
        private CategoryRepository $categoryRepository,
        private ParameterBagInterface $params,
    ) {
    }

    public function getCourses(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->courseRepository->findCourseQuery($this->query, $this->getSelectedCategory()),
            $this->page,
            $this->params->get('app.pagination.courses')
        );
    }

    /**
     * getCategories.
     *
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categoryRepository->findAll();
    }

    public function getSelectedCategory(): ?Category
    {
        if (empty($this->categorySlug)) {
            return null;
        }

        return $this->categoryRepository->findOneBy(['slug' => $this->categorySlug]);
    }
}
