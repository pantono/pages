<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\Database\OneToOne;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Contracts\Attributes\Filter;
use Pantono\Database\Traits\SavableModel;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Contracts\Attributes\DatabaseTable;

#[DatabaseTable('page_block')]
class PageBlock implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private ?int $pageVersionId = null;
    #[OneToOne(targetModel: PageBlockType::class), FieldName('block_type_id')]
    private PageBlockType $type;
    private string $content;
    /**
     * @var array<mixed>
     */
    #[Filter('json_decode')]
    private array $settings = [];
    private int $displayOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPageVersionId(): ?int
    {
        return $this->pageVersionId;
    }

    public function setPageVersionId(?int $pageVersionId): void
    {
        $this->pageVersionId = $pageVersionId;
    }

    public function getType(): PageBlockType
    {
        return $this->type;
    }

    public function setType(PageBlockType $type): void
    {
        $this->type = $type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return array<mixed>
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): void
    {
        $this->settings = $settings;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): void
    {
        $this->displayOrder = $displayOrder;
    }
}
