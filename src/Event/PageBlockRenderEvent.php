<?php

namespace Pantono\Pages\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Pantono\Pages\Model\PageBlock;

class PageBlockRenderEvent extends Event
{
    public ?PageBlock $block = null;
    private ?string $renderedContent = null;

    public function getBlock(): ?PageBlock
    {
        return $this->block;
    }

    public function setBlock(?PageBlock $block): void
    {
        $this->block = $block;
    }

    public function getRenderedContent(): ?string
    {
        return $this->renderedContent;
    }

    public function setRenderedContent(?string $renderedContent): void
    {
        $this->renderedContent = $renderedContent;
    }
}
