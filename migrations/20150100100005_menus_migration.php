<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class MenusMigration extends BasePantonoMigration
{
    public function change(): void
    {

        $this->tablePrefix('menu_item_type')
            ->addColumn('name', 'string')
            ->addColumn('external', 'boolean')
            ->create();

        $this->insertOnCreate($this->addTablePrefix('menu_item_type'), [
            ['id' => 1, 'name' => 'Page', 'external' => 0],
            ['id' => 2, 'name' => 'Product', 'external' => 0],
            ['id' => 3, 'name' => 'Category', 'external' => 0],
            ['id' => 4, 'name' => 'External', 'external' => 1],
        ]);

        $this->tablePrefix('menu')
            ->addColumn('name', 'string')
            ->addColumn('description', 'text', ['null' => true])
            ->create();

        $this->tablePrefix('menu_item')
            ->addLinkedColumn('type_id', $this->addTablePrefix('menu_item_type'), 'id')
            ->addLinkedColumn('menu_id', $this->addTablePrefix('menu'), 'id')
            ->addColumn('title', 'string', ['null' => true])
            ->addColumn('target', 'string')
            ->addColumn('display_order', 'integer')
            ->create();
    }
}
