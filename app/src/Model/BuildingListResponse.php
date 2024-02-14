<?php

namespace App\Model;

class BuildingListResponse
{
    /**
     * @param BuildingListItem[] $items
     */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return BuildingListItem[] $items
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
