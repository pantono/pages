<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\Filter;
use Pantono\Contracts\Attributes\Database\ManyToMany;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Contracts\Attributes\NoSave;
use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;

#[DatabaseTable('page_block_type')]
class PageBlockType implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private string $name;
    /**
     * @var array<mixed>
     */
    #[Filter('json_decode')]
    private array $fields = [];
    /**
     * @var PageBlockType[]
     */
    #[ManyToMany(joinTable: 'page_block_type_child', joinColumn: 'parent_block_type_id', inverseJoinColumn: 'child_block_type_id', targetModel: PageBlockType::class), FieldName('id'), NoSave]
    private array $children = [];

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

    /**
     * @return array<mixed>
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return PageBlockType[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function setChildren(array $children): void
    {
        $this->children = $children;
    }
}
