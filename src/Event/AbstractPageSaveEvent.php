<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\Page;

abstract class AbstractPageSaveEvent extends Event
{
    private Page $current;
    private ?Page $previous = null;

    public function getCurrent(): Page
    {
        return $this->current;
    }

    public function setCurrent(Page $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?Page
    {
        return $this->previous;
    }

    public function setPrevious(?Page $previous): void
    {
        $this->previous = $previous;
    }
}
