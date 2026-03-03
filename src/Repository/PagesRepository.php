<?php

namespace Pantono\Pages\Repository;

use Pantono\Database\Repository\DefaultRepository;
use Pantono\Pages\Filter\PageFilter;

class PagesRepository extends DefaultRepository
{

    /**
     * @param string $slug
     * @return array<mixed>>
     */
    public function getPageBySlug(string $slug): ?array
    {
        return $this->selectSingleRow($this->appendTablePrefix('page'), 'slug', $slug);
    }

    /**
     * @param PageFilter $filter
     * @return array<int, mixed>
     */
    public function getPagesByFilter(PageFilter $filter): array
    {
        $select = $this->getDb()->select('p.*')->from($this->appendTablePrefix('page'), 'p')
            ->innerJoin('p', $this->appendTablePrefix('page_version'), 'pv', 'p.current_version_id = pv.id');

        if ($filter->getStatus() !== null) {
            $select->where('p.status_id = :status_id')
                ->setParameter('status_id', $filter->getStatus()->getId());
        }

        if ($filter->getContentSearch() !== null) {
            $select->where('pv.content like :content_search')
                ->setParameter('content_search', '%' . $filter->getContentSearch() . '%');
        }

        if ($filter->getTitleSearch() !== null) {
            $select->where('pv.title like :title_search')
                ->setParameter('title_search', '%' . $filter->getTitleSearch() . '%');
        }

        $this->applyCountAndLimit($select, $filter);

        return $this->getDb()->fetchAll($select);
    }

    /**
     * @return array<int, mixed>
     */
    public function getStatusList(): array
    {
        return $this->selectAll($this->appendTablePrefix('page_status'));
    }
}
