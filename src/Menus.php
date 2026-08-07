<?php

namespace Pantono\Pages;

use Pantono\Pages\Repository\MenusRepository;
use Pantono\Hydrator\Hydrator;
use League\Container\Event\EventDispatcher;
use Pantono\Pages\Model\Menu;
use Pantono\Pages\Model\MenuItemFlat;
use Pantono\Pages\Event\PreMenuSaveEvent;
use Pantono\Pages\Event\PostMenuSaveEvent;
use Pantono\Pages\Model\MenuItemType;
use Pantono\Pages\Filter\MenuFilter;

class Menus
{
    private MenusRepository $repository;
    private Hydrator $hydrator;
    private EventDispatcher $dispatcher;

    public function __construct(MenusRepository $repository, Hydrator $hydrator, EventDispatcher $dispatcher)
    {
        $this->repository = $repository;
        $this->hydrator = $hydrator;
        $this->dispatcher = $dispatcher;
    }

    public function getMenuById(int $id): ?Menu
    {
        return $this->hydrator->lookupRecord(Menu::class, $id);
    }

    /**
     * @return MenuItemFlat[]
     */
    public function getFlatMenuItemsForMenuId(int $id): array
    {
        return $this->hydrator->hydrateSet(MenuItemFlat::class, $this->repository->getFlatMenuItemsForMenuId($id));
    }

    /**
     * @return Menu[]
     */
    public function getMenusByFilter(MenuFilter $filter): array
    {
        return $this->hydrator->hydrateSet(Menu::class, $this->repository->getMenusByFilter($filter));
    }

    public function saveMenu(Menu $menu): void
    {
        $previous = $menu->getId() ? $this->getMenuById($menu->getId()) : null;
        $event = new PreMenuSaveEvent();
        $event->setCurrent($menu);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);

        $this->repository->saveMenu($menu);

        $event = new PostMenuSaveEvent();
        $event->setCurrent($menu);
        $event->setPrevious($previous);
        $this->dispatcher->dispatch($event);
    }

    /**
     * @return MenuItemType[]
     */
    public function getAllMenuItemTypes(): array
    {
        return $this->hydrator->hydrateSet(MenuItemType::class, $this->repository->getAllMenuItemTypes());
    }
}
