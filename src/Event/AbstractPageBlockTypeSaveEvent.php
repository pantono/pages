<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\PageBlockType;

abstract class AbstractPageBlockTypeSaveEvent extends Event
{
    private PageBlockType $current;
    private ?PageBlockType $previous = null;

    public function getCurrent(): PageBlockType
    {
        return $this->current;
    }

    public function setCurrent(PageBlockType $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?PageBlockType
    {
        return $this->previous;
    }

    public function setPrevious(?PageBlockType $previous): void
    {
        $this->previous = $previous;
    }
}
