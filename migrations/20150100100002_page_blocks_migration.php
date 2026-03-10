<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class PageBlocksMigration extends BasePantonoMigration
{
    public function change(): void
    {
        $this->table($this->addTablePrefix('page_block_type'))
            ->addColumn('name', 'string')
            ->addColumn('fields', 'json')
            ->create();

        $this->insertOnCreate($this->addTablePrefix('page_block_type'), [
            ['name' => 'Text', 'fields' => json_encode([['name' => 'content', 'type' => 'html']])],
            ['name' => 'Image', 'fields' => json_encode([['name' => 'content', 'type' => 'image']])]
        ]);

        $this->table($this->addTablePrefix('page_block'))
            ->addLinkedColumn('page_version_id', $this->addTablePrefix('page_version'), 'id')
            ->addLinkedColumn('block_type_id', $this->addTablePrefix('page_block_type'), 'id')
            ->addColumn('content', 'json')
            ->addColumn('display_order', 'integer')
            ->create();
    }
}
