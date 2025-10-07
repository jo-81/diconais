<?php

namespace App\Twig\Components\Ideogramme;

use App\Repository\KeyRepository;
use App\Repository\KanjiRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Twig\Components\Traits\PaginationTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsLiveComponent]
final class IdeogrammeList
{
    use DefaultActionTrait;
    use PaginationTrait;

    #[LiveProp(writable: true)]
    public string $ideogrammeType = 'kanji';

    #[LiveProp(writable: true)]
    public string $query = '';

    #[LiveProp(writable: true)]
    public string $ideogramme = '';

    #[LiveProp(writable: true)]
    public string $jlpt = '';

    #[LiveProp(writable: true)]
    public ?string $numberKey = null;

    #[LiveProp(writable: true)]
    public ?string $numberStroke = null;

    #[LiveProp(writable: true)]
    public string $numberStrokeEgal = '=';

    public function __construct(
        private KanjiRepository $kanjiRepository,
        private KeyRepository $keyRepository,
        private PaginatorInterface $paginator,
        private ParameterBagInterface $params,
    ) {
    }

    public function getIdeogrammes(): PaginationInterface
    {
        $strokes = [
            'numberStroke' => $this->numberStroke,
            'egal' => $this->numberStrokeEgal,
        ];

        $ideogrammes = match ($this->ideogrammeType) {
            'kanji' => $this->kanjiRepository->findKanjiBy(
                $this->query,
                $this->ideogramme,
                $this->jlpt,
                $strokes
            ),
            'key' => $this->keyRepository->findKeyBy(
                $this->query,
                $this->ideogramme,
                $this->numberKey,
                $strokes
            ),
            default => [],
        };

        return $this->paginator->paginate($ideogrammes, $this->page, $this->params->get('app.pagination.ideogrammes'));
    }

    #[LiveAction]
    public function reset(): void
    {
        $this->resetPagination();
        $this->ideogrammeType = 'kanji';
        $this->query = '';
        $this->ideogramme = '';
        $this->jlpt = '';
        $this->numberKey = null;
        $this->numberStroke = null;
        $this->numberStrokeEgal = '=';
    }
}
