<?php

namespace App\Twig\Components\Ideogramme;

use App\Entity\Ideogramme;
use App\Repository\IdeogrammeRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Traits\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class IdeogrammeAssociated
{
    use DefaultActionTrait;
    use PaginationTrait;

    public const NUMBER_ITEMS = 6;

    #[LiveProp()]
    public string $title;

    #[LiveProp(hydrateWith: 'hydrateIdeogramme', dehydrateWith: 'dehydrateIdeogramme')]
    public array $ideogrammes;

    public function __construct(
        private IdeogrammeRepository $ideogrammeRepository,
        private PaginatorInterface $paginator,
    ) {
    }

    public function getListIdeogrammes(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->ideogrammes,
            $this->page,
            self::NUMBER_ITEMS
        );
    }

    /**
     * hydrateIdeogramme.
     *
     * @param array<string, mixed> $data
     *
     * @return Ideogramme[]
     */
    public function hydrateIdeogramme(array $data): array
    {
        $results = [];
        foreach ($data as $item) {
            $results[] = $this->ideogrammeRepository->find($item['id']);
        }

        return $results;
    }

    /**
     * dehydrateIdeogramme.
     *
     * @param Ideogramme[] $ideogrammes
     *
     * @return list<array<string, int|null>>
     */
    public function dehydrateIdeogramme(array $ideogrammes): array
    {
        $results = [];
        foreach ($ideogrammes as $ideogramme) {
            $results[] = [
                'id' => $ideogramme->getId(),
            ];
        }

        return $results;
    }
}
