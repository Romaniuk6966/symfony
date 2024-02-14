<?php
namespace App\Model;

use App\Entity\Building;
use App\Entity\Media;
use Symfony\Component\Uid\Uuid;

class ApartmentDetailItem
{
    private Uuid $id;
    private string $title;
    private string $address;
    private int $floor;
    private int $rooms;
    private float $price;
    private float $square;
    private float $living_square;
    private int $floors;
    private ?MediaListResponse $thumbnail;
    private BuildingListResponse $building;

    public function __construct(
        Uuid $id,
        string $title,
        string $address,
        int $floor,
        int $rooms,
        float $price,
        float $square,
        float $living_square,
        int $floors,
        ?MediaListResponse $thumbnail,
        BuildingListResponse $building
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->address = $address;
        $this->floor = $floor;
        $this->rooms = $rooms;
        $this->price = $price;
        $this->square = $square;
        $this->living_square = $living_square;
        $this->floors = $floors;
        $this->thumbnail = $thumbnail;
        $this->building = $building;
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

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function getRooms(): int
    {
        return $this->rooms;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getSquare(): float
    {
        return $this->square;
    }

    public function getLivingSquare(): float
    {
        return $this->living_square;
    }

    public function getFloors(): int
    {
        return $this->floors;
    }

    public function getThumbnail(): ?MediaListResponse
    {
        return $this->thumbnail;
    }

    public function getBuilding(): BuildingListResponse
    {
        return $this->building;
    }
}
