<?php

namespace Pantono\Pages\Filter;

use Pantono\Contracts\Filter\PageableInterface;
use Pantono\Database\Traits\Pageable;

class MenuFilter implements PageableInterface
{
    use Pageable;

    private ?string $search = null;

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }
}
