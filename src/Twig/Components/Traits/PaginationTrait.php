<?php

namespace App\Twig\Components\Traits;

use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

trait PaginationTrait
{
    #[LiveProp(writable: true, url: true)]
    public int $page = 1;

    #[LiveAction]
    public function nextPage(): void
    {
        $this->page = max(1, $this->page + 1);
    }

    #[LiveAction]
    public function prevPage(): void
    {
        $this->page = max(1, $this->page - 1);
    }

    #[LiveAction]
    public function selectedPage(#[LiveArg] int $page): void
    {
        $this->page = $page;
    }
}
