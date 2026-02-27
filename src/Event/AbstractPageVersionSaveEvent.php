<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\PageVersion;

class AbstractPageVersionSaveEvent extends Event
{
    private PageVersion $current;
    private ?PageVersion $previous = null;

    public function getCurrent(): PageVersion
    {
        return $this->current;
    }

    public function setCurrent(PageVersion $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?PageVersion
    {
        return $this->previous;
    }

    public function setPrevious(?PageVersion $previous): void
    {
        $this->previous = $previous;
    }
}
