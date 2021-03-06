<?php

namespace App\Domain\BO;

use App\Domain\DAO\CategoryDAO;
use App\Domain\DAO\CategoryItemDAO;
use App\Domain\DAO\VersionDAO;
use App\Domain\DTO\CategoryDTO;
use App\Domain\DTO\CategoryItemDTO;
use App\Models\Version;

class POFormBO
{
    /** @var CategoryDAO */
    private $categoryDAO;

    /** @var VersionDAO */
    private $versionDAO;

    /** @var CategoryItemDAO */
    private $categoryItemDAO;

    public function __construct(CategoryDAO $categoryDAO, CategoryItemDAO $categoryItemDAO, VersionDAO $versionDAO)
    {
        $this->categoryDAO = $categoryDAO;
        $this->versionDAO = $versionDAO;
        $this->categoryItemDAO = $categoryItemDAO;
    }

    public function updatePOForm(array $requestData)
    {
        $newVersion = $this->createNewVersion();
        $categoryRank = 1;

        foreach ($requestData['category'] as $requestCategory) {
            $category = $this->categoryDAO->create(
                new CategoryDTO(
                    $newVersion,
                    $requestCategory['name'] ?? 'default',
                    $requestCategory['price'] ?? 0.00,
                    isset($requestCategory['enabled']) ? 1 : 0,
                    $categoryRank
                )
            );

            $itemRank = 1;

            if (isset($requestCategory['items'])) {
                foreach ($requestCategory['items'] as $item) {
                    $this->categoryItemDAO->create(
                        new CategoryItemDTO(
                            $newVersion,
                            $category->id,
                            $item['name'] ?? 'default',
                            $item['description'] ?? null,
                            $item['price'] ?? null,
                            $item['sku'] ?? null,
                            isset($item['enabled']) ? 1 : 0,
                            $itemRank
                        )
                    );
                    $itemRank++;
                }
            }
            $categoryRank++;
        }
    }

    private function createNewVersion(): int
    {
        return $this->versionDAO->bumpVersionNumber();
    }
}
