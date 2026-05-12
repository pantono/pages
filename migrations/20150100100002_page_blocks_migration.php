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
            [
                'id' => 1,
                'name' => 'Row',
                'fields' => json_encode([
                    ['name' => 'columns', 'type' => 'integer', 'default' => 12],
                    ['name' => 'gap', 'type' => 'integer', 'default' => 0],
                ]),
            ],
            [
                'id' => 2,
                'name' => 'Item',
                'fields' => json_encode([
                    ['name' => 'column_span', 'type' => 'integer', 'default' => 12],
                    ['name' => 'column_start', 'type' => 'integer', 'default' => 1],
                ]),
            ],
            ['id' => 3, 'name' => 'Text', 'fields' => json_encode([['name' => 'content', 'type' => 'html']])],
            ['id' => 4, 'name' => 'Image', 'fields' => json_encode([['name' => 'content', 'type' => 'image']])],
        ]);

        $this->table($this->addTablePrefix('page_block_type_child'), ['id' => false])
            ->addLinkedColumn('parent_block_type_id', $this->addTablePrefix('page_block_type'), 'id')
            ->addLinkedColumn('child_block_type_id', $this->addTablePrefix('page_block_type'), 'id')
            ->addIndex(['parent_block_type_id', 'child_block_type_id'], ['unique' => true])
            ->create();

        $this->insertOnCreate($this->addTablePrefix('page_block_type_child'), [
            ['parent_block_type_id' => 1, 'child_block_type_id' => 2], // Row -> Item
            ['parent_block_type_id' => 2, 'child_block_type_id' => 3], // Item -> Text
            ['parent_block_type_id' => 2, 'child_block_type_id' => 4], // Item -> Image
        ], false);

        $this->table($this->addTablePrefix('page_block'))
            ->addLinkedColumn('page_version_id', $this->addTablePrefix('page_version'), 'id')
            ->addLinkedColumn('parent_block_id', $this->addTablePrefix('page_block'), 'id', ['null' => true], ['delete' => 'SET NULL'])
            ->addLinkedColumn('block_type_id', $this->addTablePrefix('page_block_type'), 'id')
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('settings', 'json', ['null' => true])
            ->addColumn('display_order', 'integer', ['default' => 0])
            ->addIndex(['page_version_id', 'parent_block_id', 'display_order'])
            ->addIndex(['parent_block_id', 'display_order'])
            ->create();
    }
}
