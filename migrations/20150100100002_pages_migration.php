<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class PagesMigration extends BasePantonoMigration
{
    public function change(): void
    {
        $this->table($this->addTablePrefix('page_status'))
            ->addColumn('name', 'string')
            ->addColumn('draft', 'boolean')
            ->addColumn('published', 'boolean')
            ->addColumn('deleted', 'boolean')
            ->create();

        $this->insertOnCreate($this->addTablePrefix('page_status'), [
            ['id' => 1, 'name' => 'Draft', 'draft' => true, 'published' => false, 'deleted' => false],
            ['id' => 2, 'name' => 'Published', 'draft' => false, 'published' => true, 'deleted' => false],
            ['id' => 3, 'name' => 'Deleted', 'draft' => false, 'published' => false, 'deleted' => true],
        ]);

        $this->table($this->addTablePrefix('page'))
            ->addColumn('slug', 'string')
            ->addColumn('date_created', 'datetime')
            ->addColumn('date_updated', 'datetime')
            ->addColumn('current_version_id', 'integer', ['null' => true])
            ->addLinkedColumn('status_id', $this->addTablePrefix('page_status'), 'id')
            ->create();

        $this->table($this->addTablePrefix('page_version'))
            ->addLinkedColumn('page_id', $this->addTablePrefix('page'), 'id')
            ->addLinkedColumn('created_by_id', $this->addTablePrefix('user'), 'id')
            ->addColumn('date_created', 'datetime')
            ->addColumn('slug', 'string')
            ->addColumn('page_title', 'text')
            ->addColumn('meta_title', 'text', ['null' => true])
            ->addColumn('meta_description', 'text', ['null' => true])
            ->addColumn('meta_robots', 'string', ['null' => true])
            ->addColumn('meta_keywords', 'text', ['null' => true])
            ->addColumn('og_title', 'text', ['null' => true])
            ->addColumn('og_description', 'text', ['null' => true])
            ->addColumn('canonical_url', 'string', ['null' => true])
            ->addColumn('include_in_sitemap', 'boolean')
            ->addColumn('content', 'text')
            ->addLinkedColumn('og_image_id', $this->addTablePrefix('image'), 'id')
            ->create();

        if ($this->isMigratingUp()) {
            $this->table($this->addTablePrefix('page'))
                ->addForeignKey('current_version_id', $this->addTablePrefix('page_version'), 'id')
                ->update();
        }

        $this->table($this->addTablePrefix('redirect'), ['id' => false])
            ->addColumn('from', 'string')
            ->addColumn('to', 'string')
            ->addColumn('status_code', 'integer', ['default' => 301])
            ->addIndex('from', ['unique' => true])
            ->create();
    }
}
