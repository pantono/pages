<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\PageStatus;

abstract class AbstractPageStatusSaveEvent extends Event
{
    private PageStatus $status;
    private ?PageStatus $previous = null;

    public function getStatus(): PageStatus
    {
        return $this->status;
    }

    public function setStatus(PageStatus $status): void
    {
        $this->status = $status;
    }

    public function getPrevious(): ?PageStatus
    {
        return $this->previous;
    }

    public function setPrevious(?PageStatus $previous): void
    {
        $this->previous = $previous;
    }
}
