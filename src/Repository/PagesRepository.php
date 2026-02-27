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
        $select = $this->getDb()->select()->from($this->appendTablePrefix('page'))
            ->joinInner($this->appendTablePrefix('page_version'), $this->appendTablePrefix('page_version') . '.page_id = ' . $this->appendTablePrefix('page') . '.id', []);

        if ($filter->getStatus() !== null) {
            $select->where($this->appendTablePrefix('page') . '.status_id = ?', $filter->getStatus()->getId());
        }

        if ($filter->getContentSearch() !== null) {
            $select->where($this->appendTablePrefix('page_version') . '.content like ?', '%' . $filter->getContentSearch() . '%');
        }

        if ($filter->getTitleSearch() !== null) {
            $select->where($this->appendTablePrefix('page_version') . '.title like ?', '%' . $filter->getTitleSearch() . '%');
        }

        $filter->setTotalResults($this->getCount($select));
        $select->limitPage($filter->getPage(), $filter->getPerPage());

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
