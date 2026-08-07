<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\Database\OneToOne;
use Pantono\Contracts\Attributes\FieldName;

#[DatabaseTable('menu_item')]
class MenuItem implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    #[OneToOne(targetModel: MenuItemType::class), FieldName('type_id')]
    private ?MenuItemType $type = null;
    private int $menuId;
    private string $target;
    private ?string $title = null;
    private int $displayOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getType(): ?MenuItemType
    {
        return $this->type;
    }

    public function setType(?MenuItemType $type): void
    {
        $this->type = $type;
    }

    public function getMenuId(): int
    {
        return $this->menuId;
    }

    public function setMenuId(int $menuId): void
    {
        $this->menuId = $menuId;
    }

    public function getTarget(): string
    {
        return $this->target;
    }

    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): void
    {
        $this->displayOrder = $displayOrder;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
}
