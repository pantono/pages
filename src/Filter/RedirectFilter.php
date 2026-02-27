<?php

namespace Pantono\Pages\Filter;

use Pantono\Contracts\Filter\PageableInterface;
use Pantono\Database\Traits\Pageable;

class RedirectFilter implements PageableInterface
{
    use Pageable;

    private ?string $fromSearch = null;
    private ?string $toSearch = null;
    private ?int $statusCode = null;

    public function getFromSearch(): ?string
    {
        return $this->fromSearch;
    }

    public function setFromSearch(?string $fromSearch): void
    {
        $this->fromSearch = $fromSearch;
    }

    public function getToSearch(): ?string
    {
        return $this->toSearch;
    }

    public function setToSearch(?string $toSearch): void
    {
        $this->toSearch = $toSearch;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(?int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }
}
