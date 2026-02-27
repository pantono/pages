<?php

namespace Pantono\Pages\Filter;

use Pantono\Contracts\Filter\PageableInterface;
use Pantono\Database\Traits\Pageable;
use Pantono\Pages\Model\PageStatus;

class PageFilter implements PageableInterface
{
    use Pageable;

    private ?PageStatus $status = null;
    private ?string $search = null;
    private ?string $titleSearch = null;
    private ?string $contentSearch = null;

    public function getStatus(): ?PageStatus
    {
        return $this->status;
    }

    public function setStatus(?PageStatus $status): void
    {
        $this->status = $status;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    public function getTitleSearch(): ?string
    {
        return $this->titleSearch;
    }

    public function setTitleSearch(?string $titleSearch): void
    {
        $this->titleSearch = $titleSearch;
    }

    public function getContentSearch(): ?string
    {
        return $this->contentSearch;
    }

    public function setContentSearch(?string $contentSearch): void
    {
        $this->contentSearch = $contentSearch;
    }
}
