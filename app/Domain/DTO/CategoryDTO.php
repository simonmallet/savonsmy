<?php

namespace App\Domain\DTO;

class CategoryDTO
{
    private $version;
    private $name;
    private $price;
    private $enabled;
    private $rank;

    public function __construct(int $version, string $name, float $price, bool $enabled, int $rank)
    {
        $this->version = $version;
        $this->name = $name;
        $this->price = $price;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
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
