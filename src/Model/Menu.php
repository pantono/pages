<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Attributes\Database\OneToMany;

#[DatabaseTable('menu')]
class Menu implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private string $name;
    private string $description;
    private bool $deleted;
    /**
     * @var MenuItem[]
     */
    #[OneToMany(targetModel: MenuItem::class, mappedBy: 'menu_id')]
    private array $items = [];

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return MenuItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(MenuItem $item): void
    {
        $items = $this->getItems();
        $items[] = $item;
        $this->items = $items;
    }

    /**
     * @return array<int,mixed>
     */
    public function getItemArray(): array
    {
        $items = [];
        foreach ($this->getItems() as $item) {
            $items[] = [
                'id' => $item->getId(),
                'target' => $item->getTarget(),
                'display_order' => $item->getDisplayOrder(),
                'title' => $item->getTitle(),
            ];
        }
        return $items;
    }
}
