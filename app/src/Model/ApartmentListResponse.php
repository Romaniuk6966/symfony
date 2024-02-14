<?php

namespace App\Model;

class ApartmentListResponse
{
    /**
     * @param ApartmentListItem[] $items
     */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return ApartmentListItem[] $items
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
