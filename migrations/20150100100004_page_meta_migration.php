<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class PageMetaMigration extends BasePantonoMigration
{
    public function change(): void
    {
        $this->tablePrefix('page_version')
            ->addColumn('meta', 'json')
            ->create();
    }
}
