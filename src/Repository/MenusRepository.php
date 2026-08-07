<?php

namespace Pantono\Pages\Repository;

use Pantono\Database\Repository\DefaultRepository;
use Pantono\Pages\Model\Menu;
use Doctrine\DBAL\ArrayParameterType;

class MenusRepository extends DefaultRepository
{

    /**
     * @return array<int, mixed>
     */
    public function getFlatMenuItemsForMenuId(int $id): array
    {
        $select = $this->getDb()->select(
            'mi.id',
            'CASE
                WHEN mi.type_id = 1 THEN p.slug
                WHEN mi.type_id = 2 THEN pr.slug
                WHEN mi.type_id = 3 THEN c.slug
                ELSE mi.target
            END AS target',
            'CASE
                WHEN mi.type_id = 1 THEN pv.page_title
                WHEN mi.type_id = 2 THEN pr.title
                WHEN mi.type_id = 3 THEN c.title
                ELSE mi.title
            END AS title',
            'mit.external'
        )->from($this->pt('menu_item'), 'mi')
            ->innerJoin('mi', $this->pt('menu_item_type'), 'mit', 'mi.type_id = mit.id')
            ->leftJoin('mi', $this->pt('page'), 'p', 'mi.type_id = 1 AND mi.target = p.id')
            ->leftJoin('p', $this->pt('page_version'), 'pv', 'p.current_version_id = pv.id')
            ->leftJoin('mi', $this->pt('product'), 'pr', 'mi.type_id = 2 AND mi.target = pr.id')
            ->leftJoin('mi', $this->pt('category'), 'c', 'mi.type_id = 3 AND mi.target = c.id')
            ->where('mi.menu_id = :menu_id')
            ->setParameter('menu_id', $id)
            ->orderBy('mi.display_order');

        return $this->getDb()->fetchAll($select);
    }

    public function saveMenu(Menu $menu): void
    {
        $id = $this->insertOrUpdate($this->pt('menu'), 'id', $menu->getId(), $menu->getAllData());
        if ($id) {
            $menu->setId($id);
        }

        $deleteQb = $this->getDb()->createQueryBuilder()->delete($this->pt('menu_item'))
            ->andWhere('menu_item.menu_id = :menu_id')
            ->setParameter('menu_id', $menu->getId());
        $ids = [];
        foreach ($menu->getItems() as $item) {
            $item->setMenuId($menu->getId());
            $id = $this->insertOrUpdate($this->pt('menu_item'), 'id', $item->getId(), $item->getAllData());
            if ($id) {
                $item->setId($id);
            }
            $ids[] = $item->getId();
        }
        if (!empty($ids)) {
            $deleteQb->andWhere('menu_item.id NOT IN (:ids)')
                ->setParameter('ids', $ids, ArrayParameterType::INTEGER);
        }
        $deleteQb->executeQuery();
    }
}
