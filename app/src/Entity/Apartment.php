<?php

namespace App\Entity;

use App\Repository\ApartmentRepository;
use App\Trait\RawLoader;
use App\Trait\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ApartmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Apartment
{
    use TimestampableEntity;
    use RawLoader;
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $floor = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rooms = null;

    #[ORM\ManyToOne(inversedBy: 'apartments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Building $building = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $square = null;

    #[ORM\Column]
    private ?float $living_square = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $floors = null;

    #[ORM\ManyToOne(inversedBy: 'thumbnail')]
    private ?Media $thumbnail = null;

    #[ORM\ManyToMany(targetEntity: Metadata::class, inversedBy: 'apartments')]
    private Collection $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

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
        return $this->building;
    }

    public function setBuilding(?Building $building): static
    {
        $this->building = $building;

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

    public function getThumbnail(): ?Media
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?Media $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * @return Collection<int, Metadata>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Metadata $attribute): static
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
        }

        return $this;
    }

    public function removeAttribute(Metadata $attribute): static
    {
        $this->attributes->removeElement($attribute);

        return $this;
    }
}
