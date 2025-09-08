<?php

namespace App\Twig\Components\Kana;

use App\Repository\KanaRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Traits\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class KanaList
{
    use DefaultActionTrait;
    use PaginationTrait;

    #[LiveProp(writable: true, url: true)]
    public string $accent = '';

    #[LiveProp(writable: true, url: true)]
    public string $combination = '';

    #[LiveProp(writable: true, url: true)]
    public string $type = '';

    #[LiveProp(writable: true, url: true)]
    public string $query = '';

    public const NUMBER_ITEMS = 24;

    public function __construct(private KanaRepository $kanaRepository, private PaginatorInterface $paginator)
    {
    }

    public function getKanas(): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->kanaRepository->filterListKana($this->query, $this->type, $this->accent, $this->combination),
            $this->page,
            self::NUMBER_ITEMS
        );
    }
}
