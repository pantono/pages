<?php

namespace Pantono\Pages\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Pantono\Pages\Event\PostMenuSaveEvent;
use Pantono\Logger\AuditLogger;

class MenuEvents implements EventSubscriberInterface
{
    private AuditLogger $logger;

    public function __construct(AuditLogger $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostMenuSaveEvent::class => [
                ['saveLog', 255]
            ]
        ];
    }

    public function saveLog(PostMenuSaveEvent $event): void
    {
        $current = $event->getCurrent();
        $previous = $event->getPrevious();

        if (!$previous) {
            $this->logger->addLogForModel($current::class, (string)$current->getId(), 'Created new menu', [], $current->getAllData());
            return;
        }
        $this->logger->autoLog($current, $previous);

        if (json_encode($previous->getItemArray()) !== json_encode($current->getItemArray())) {
            $this->logger->addLogForModel($current::class, (string)$current->getId(), 'Updated menu items', $previous->getItemArray(), $current->getItemArray());
        }
    }
}
