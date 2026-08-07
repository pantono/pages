<?php

namespace Pantono\Pages\Filter;

use Pantono\Contracts\Filter\PageableInterface;
use Pantono\Database\Traits\Pageable;

class MenuFilter implements PageableInterface
{
    use Pageable;

    private ?string $search = null;
    private ?bool $includeDeleted = false;

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    public function getIncludeDeleted(): ?bool
    {
        return $this->includeDeleted;
    }

    public function setIncludeDeleted(?bool $includeDeleted): void
    {
        $this->includeDeleted = $includeDeleted;
    }
}
