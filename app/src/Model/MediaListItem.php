<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Uid\Uuid;

class MediaListItem
{
    private Uuid $uuid;
    private string $type;
    private int $imageSize;
    private string $imageName;

    public function __construct(Uuid $uuid, string $type, int $imageSize, string $imageName)
    {
        $this->uuid = $uuid;
        $this->type = $type;
        $this->imageSize = $imageSize;
        $this->imageName = $imageName;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getImageSize(): int
    {
        return $this->imageSize;
    }
    public function getImageName(): string
    {
        return $this->imageName;
    }

}