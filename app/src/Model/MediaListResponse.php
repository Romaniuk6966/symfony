<?php
namespace App\Model;

class MediaListResponse
{
    /**
     * @param MediaListItem[] $items
     */
    private array $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return MediaListItem[] $items
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
