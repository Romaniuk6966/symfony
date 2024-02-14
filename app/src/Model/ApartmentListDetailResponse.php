<?php

namespace App\Model;

class ApartmentListDetailResponse
{
    /**
     * @param ApartmentDetailItem[] $items
     */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return ApartmentDetailItem[] $items
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
