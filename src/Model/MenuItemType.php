<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;

#[DatabaseTable('menu_item_type')]
class MenuItemType implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private string $name;
    private bool $external;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isExternal(): bool
    {
        return $this->external;
    }

    public function setExternal(bool $external): void
    {
        $this->external = $external;
    }
}
