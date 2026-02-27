<?php

namespace Pantono\Pages;

use Pantono\Pages\Repository\PagesRepository;
use Pantono\Hydrator\Hydrator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Pantono\Pages\Model\Page;
use Pantono\Pages\Event\PrePageSaveEvent;
use Pantono\Pages\Event\PostPageSaveEvent;
use Pantono\Pages\Model\PageVersion;
use Pantono\Pages\Event\PrePageVersionSaveEvent;
use Pantono\Pages\Event\PostPageVersionSaveEvent;
use Pantono\Pages\Filter\PageFilter;
use Pantono\Pages\Model\PageStatus;
use Pantono\Pages\Event\PrePageStatusSaveEvent;
use Pantono\Pages\Event\PostPageStatusSaveEvent;

class Pages
{
    private PagesRepository $repository;
    private Hydrator $hydrator;
    private EventDispatcher $dispatcher;

    public function __construct(PagesRepository $repository, Hydrator $hydrator, EventDispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->dispatcher = $dispatcher;
    }

    public function getPageById(int $id): ?Page
    {
        return $this->hydrator->lookupRecord(Page::class, $id);
    }

    /**
     * @return PageStatus[]
     */
    public function getStatusList(): array
    {
        return $this->hydrator->hydrateSet(PageStatus::class, $this->repository->getStatusList());
    }

    public function getPageBySlug(string $slug): ?Page
    {
        return $this->hydrator->hydrate(Page::class, $this->repository->getPageBySlug($slug));
    }

    /**
     * @param PageFilter $filter
     * @return Page[]
     */
    public function getPagesByFilter(PageFilter $filter): array
    {
        return $this->hydrator->hydrateSet(Page::class, $this->repository->getPagesByFilter($filter));
    }

    public function savePage(Page $page): void
    {
        $previous = $page->getId() ? $this->hydrator->lookupRecord(Page::class, $page->getId()) : null;
        $event = new PrePageSaveEvent();
        $event->setCurrent($page);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);

        $this->repository->saveModel($page);

        $event = new PostPageSaveEvent();
        $event->setCurrent($page);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);
    }

    public function saveVersion(PageVersion $version): void
    {
        $previous = $version->getId() ? $this->hydrator->lookupRecord(PageVersion::class, $version->getId()) : null;
        $event = new PrePageVersionSaveEvent();
        $event->setCurrent($version);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);

        $this->repository->saveModel($version);

        $event = new PostPageVersionSaveEvent();
        $event->setCurrent($version);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);
    }

    public function savePageStatus(PageStatus $status): void
    {
        $previous = $status->getId() ? $this->hydrator->lookupRecord(PageStatus::class, $status->getId()) : null;
        $event = new PrePageStatusSaveEvent();
        $event->setStatus($status);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);

        $this->repository->saveModel($status);

        $event = new PostPageStatusSaveEvent();
        $event->setStatus($status);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);
    }
}
