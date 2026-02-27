<?php

namespace Pantono\Pages;

use Pantono\Pages\Repository\RedirectsRepository;
use Pantono\Hydrator\Hydrator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Pantono\Pages\Filter\RedirectFilter;
use Pantono\Pages\Model\Redirect;
use Pantono\Pages\Event\PreRedirectSaveEvent;
use Pantono\Pages\Event\PostRedirectSaveEvent;

class Redirects
{
    private RedirectsRepository $repository;
    private Hydrator $hydrator;
    private EventDispatcher $dispatcher;

    public function __construct(RedirectsRepository $repository, Hydrator $hydrator, EventDispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->dispatcher = $dispatcher;
    }

    public function getRedirectForSlug(string $slug): ?Redirect
    {
        return $this->hydrator->hydrate(Redirect::class, $this->repository->getRedirectForSlug($slug));
    }

    /**
     * @param RedirectFilter $filter
     * @return Redirect[]
     */
    public function getRedirectsByFilter(RedirectFilter $filter): array
    {
        return $this->hydrator->hydrateSet(Redirect::class, $this->repository->getRedirectsByFilter($filter));
    }

    public function saveRedirect(Redirect $redirect): void
    {
        $event = new PreRedirectSaveEvent();
        $event->setRedirect($redirect);
        $this->dispatcher->dispatch($event);

        $this->repository->saveRedirect($redirect);

        $event = new PostRedirectSaveEvent();
        $event->setRedirect($redirect);
        $this->dispatcher->dispatch($event);
    }
}
