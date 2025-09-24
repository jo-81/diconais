<?php

namespace App\Twig\Components\Kanji;

use App\Repository\VocabularyRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Traits\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class KanjiVocabularies
{
    use DefaultActionTrait;
    use PaginationTrait;

    public const NUMBER_ITEMS = 5;

    #[LiveProp(hydrateWith: 'hydrateVocabulary', dehydrateWith: 'dehydrateVocabulary')]
    public array $vocabularies = [];

    public function __construct(
        private VocabularyRepository $vocabularyRepository,
        private PaginatorInterface $paginator,
    ) {
    }

    public function getListVocabularies(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->vocabularies,
            $this->page,
            self::NUMBER_ITEMS
        );
    }

    public function getIndex(int $index): int
    {
        return ($this->page - 1) * self::NUMBER_ITEMS + $index;
    }

    public function hydrateVocabulary(array $data): array
    {
        $results = [];
        foreach ($data as $item) {
            $results[] = $this->vocabularyRepository->find($item['id']);
        }

        return $results;
    }

    public function dehydrateVocabulary(array $vocabularies): array
    {
        $results = [];
        foreach ($vocabularies as $vocabulary) {
            $results[] = [
                'id' => $vocabulary->getId(),
            ];
        }

        return $results;
    }
}
