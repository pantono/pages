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
        $select = $this->getDb()->select('r.*')->from($this->appendTablePrefix('redirect'), 'r');

        if ($filter->getFromSearch() !== null) {
            $select->where('r.from LIKE :from_search')
                ->setParameter('from_search', '%' . $filter->getFromSearch() . '%');
        }
        if ($filter->getToSearch() !== null) {
            $select->where('r.to LIKE :to_search')
                ->setParameter('to_search', '%' . $filter->getToSearch() . '%');
        }
        if ($filter->getStatusCode() !== null) {
            $select->where('r.status_code=:status_code')
                ->setParameter('status_code', $filter->getStatusCode());
        }

        $this->applyCountAndLimit($select, $filter);

        return $this->getDb()->fetchAll($select);
    }
}
