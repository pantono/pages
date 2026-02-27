<?php

namespace Pantono\Pages\Model;

use Pantono\Contracts\Attributes\DatabaseTable;
use Pantono\Contracts\Attributes\Database\OneToOne;
use Pantono\Contracts\Attributes\FieldName;
use Pantono\Contracts\Attributes\Database\OneToMany;
use Pantono\Contracts\Attributes\Lazy;
use Pantono\Contracts\Attributes\NoSave;
use Pantono\Contracts\Application\Interfaces\SavableInterface;
use Pantono\Database\Traits\SavableModel;

#[DatabaseTable('page')]
class Page implements SavableInterface
{
    use SavableModel;

    private ?int $id = null;
    private string $slug;
    private \DateTimeInterface $dateCreated;
    private \DateTimeInterface $dateUpdated;
    #[OneToOne(targetModel: PageStatus::class), FieldName('status_id')]
    private ?PageStatus $status = null;
    #[OneToOne(targetModel: PageVersion::class), FieldName('current_version_id')]
    private ?PageVersion $currentVersion = null;
    /**
     * @var PageVersion[]
     */
    #[OneToMany(targetModel: PageVersion::class, mappedBy: 'page_id'), Lazy, NoSave]
    private array $allVersions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getDateCreated(): \DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    public function getDateUpdated(): \DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTimeInterface $dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    public function getStatus(): ?PageStatus
    {
        return $this->status;
    }

    public function setStatus(?PageStatus $status): void
    {
        $this->status = $status;
    }

    public function getCurrentVersion(): ?PageVersion
    {
        return $this->currentVersion;
    }

    public function setCurrentVersion(?PageVersion $currentVersion): void
    {
        $this->currentVersion = $currentVersion;
    }

    /**
     * @return PageVersion[]
     */
    public function getAllVersions(): array
    {
        return $this->allVersions;
    }

    public function setAllVersions(array $allVersions): void
    {
        $this->allVersions = $allVersions;
    }
}
