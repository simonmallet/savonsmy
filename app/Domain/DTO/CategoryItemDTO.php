<?php

namespace App\Domain\DTO;

class CategoryItemDTO
{
    private $version;
    private $categoryId;
    private $name;
    private $description;
    private $price;
    private $sku;
    private $enabled;
    private $rank;

    public function __construct(int $version, int $categoryId, string $name, ?string $description, ?float $price, ?string $sku, bool $enabled, int $rank)
    {
        $this->version = $version;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->sku = $sku;
        $this->enabled = $enabled;
        $this->rank = $rank;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

}
