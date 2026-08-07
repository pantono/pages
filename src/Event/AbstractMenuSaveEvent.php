<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\Menu;

class AbstractMenuSaveEvent extends Event
{
    private Menu $current;
    private ?Menu $previous = null;

    public function getCurrent(): Menu
    {
        return $this->current;
    }

    public function setCurrent(Menu $current): void
    {
        $this->current = $current;
    }

    public function getPrevious(): ?Menu
    {
        return $this->previous;
    }

    public function setPrevious(?Menu $previous): void
    {
        $this->previous = $previous;
    }
}
