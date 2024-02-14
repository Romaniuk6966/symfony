<?php
namespace App\Model;

use App\Entity\Building;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

class ApartmentRequest
{
    #[Assert\NotBlank]
    public string $title;

    #[Assert\NotBlank]
    public string $address;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public int $floor;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public int $rooms;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'float', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public float $price;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'float', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public float $square;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'float', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public float $living_square;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer', message: 'The value {{ value }} is not a valid {{ type }}.')]
    public int $floors;

    #[Assert\NotBlank]
    #[Assert\Uuid]
    public Uuid $buildingUuid;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): static
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->buildingUuid;
    }

    public function setBuilding(Uuid $buildingUuid): static
    {

        $this->buildingUuid = $buildingUuid;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getSquare(): ?float
    {
        return $this->square;
    }

    public function setSquare(float $square): static
    {
        $this->square = $square;

        return $this;
    }

    public function getLivingSquare(): ?float
    {
        return $this->living_square;
    }

    public function setLivingSquare(float $living_square): static
    {
        $this->living_square = $living_square;

        return $this;
    }

    public function getFloors(): ?int
    {
        return $this->floors;
    }

    public function setFloors(?int $floors): static
    {
        $this->floors = $floors;

        return $this;
    }
}