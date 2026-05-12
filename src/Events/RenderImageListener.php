<?php

namespace Pantono\Pages\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pantono\Images\Images;
use Pantono\Pages\Event\PageBlockRenderEvent;

class RenderImageListener implements EventSubscriberInterface
{
    private Images $images;

    public function __construct(Images $images)
    {
        $this->images = $images;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PageBlockRenderEvent::class => [
                ['renderImage', -255]
            ]
        ];
    }


    public function renderImage(PageBlockRenderEvent $renderEvent): void
    {
        $block = $renderEvent->getBlock();
        if ($block->getType()->getDisplayType() === 'image') {
            $imageId = (int)$block->getContent();
            $image = $this->images->getImageById($imageId);
            if ($image) {
                $renderEvent->setRenderedContent($image->getUrl());
            }
        }
    }
}
