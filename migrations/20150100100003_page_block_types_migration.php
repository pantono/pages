<?php

declare(strict_types=1);

use Pantono\Database\Migration\Base\BasePantonoMigration;

final class PageBlocksMigration extends BasePantonoMigration
{
    public function up(): void
    {
        $this->table($this->addTablePrefix('page_block_type'))
            ->addColumn('display_type', 'string', ['default' => '', 'after' => 'name'])
            ->update();
        $this->query('UPDATE ' . $this->addTablePrefix('page_block_type') . ' SET display_type = \'row\' where id=1');
        $this->query('UPDATE ' . $this->addTablePrefix('page_block_type') . ' SET display_type = \'column\' where id=2');
        $this->query('UPDATE ' . $this->addTablePrefix('page_block_type') . ' SET display_type = \'text\' where id=3');
        $this->query('UPDATE ' . $this->addTablePrefix('page_block_type') . ' SET display_type = \'image\' where id=4');
    }

    public function down(): void
    {
        $this->table($this->addTablePrefix('page_block_type'))
            ->removeColumn('block_type')
            ->update();
    }
}
