<?php

namespace App\Model;

use Symfony\Component\Uid\Uuid;

class BuildingListItem
{
    private Uuid $id;
    private string $title;

    private string $address;

    private float $latitude;

    private float $longitude;

    private int $floors;

    private int $year;

    public function __construct(Uuid $id, string $title, string $address, float $latitude, float $longitude, int $floors, int $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->floors = $floors;
        $this->year = $year;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getFloors(): int
    {
        return $this->floors;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
