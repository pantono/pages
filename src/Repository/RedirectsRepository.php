<?php

namespace Pantono\Pages\Repository;

use Pantono\Database\Repository\DefaultRepository;
use Pantono\Pages\Model\Redirect;
use Pantono\Pages\Filter\RedirectFilter;

class RedirectsRepository extends DefaultRepository
{
    /**
     * @param string $slug
     * @return array<mixed>
     */
    public function getRedirectForSlug(string $slug): ?array
    {
        return $this->selectSingleRow('redirect', 'from', $slug);
    }

    public function saveRedirect(Redirect $redirect): void
    {
        $this->getDb()->delete('redirect', ['from' => $redirect->getFrom()]);
        $this->getDb()->insert('redirect', [
            'from' => $redirect->getFrom(),
            'to' => $redirect->getTo(),
            'status_code' => $redirect->getStatusCode(),
        ]);
    }

    /**
     * @param RedirectFilter $filter
     * @return array<int, mixed>
     */
    public function getRedirectsByFilter(RedirectFilter $filter): array
    {
        $select = $this->getDb()->select()->from('redirect');

        if ($filter->getFromSearch() !== null) {
            $select->where('from LIKE ?', '%' . $filter->getFromSearch() . '%');
        }
        if ($filter->getToSearch() !== null) {
            $select->where('to LIKE ?', '%' . $filter->getToSearch() . '%');
        }
        if ($filter->getStatusCode() !== null) {
            $select->where('status_code=?', $filter->getStatusCode());
        }

        $filter->setTotalResults($this->getCount($select));
        $select->limitPage($filter->getPage(), $filter->getPerPage());

        return $this->getDb()->fetchAll($select);
    }
}
