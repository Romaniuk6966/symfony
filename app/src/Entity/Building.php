<?php

namespace App\Entity;

use App\Repository\BuildingRepository;
use App\Trait\RawLoader;
use App\Trait\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BuildingRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Building
{
    use TimestampableEntity;
    use RawLoader;
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $floors = null;

    #[ORM\OneToMany(mappedBy: 'building', targetEntity: Apartment::class, orphanRemoval: true)]
    private Collection $apartments;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $year = null;

    #[ORM\ManyToOne(inversedBy: 'buildings')]
    private ?Media $thumbnail = null;

    #[ORM\ManyToMany(targetEntity: Metadata::class, inversedBy: 'buildings')]
    private Collection $attributes;

    public function __construct()
    {
        $this->apartments = new ArrayCollection();
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

    public function setTitle(string $title): static
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getFloors(): ?int
    {
        return $this->floors;
    }

    public function setFloors(int $floors): static
    {
        $this->floors = $floors;

        return $this;
    }

    /**
     * @return Collection<int, Apartment>
     */
    public function getApartments(): Collection
    {
        return $this->apartments;
    }

    public function addApartment(Apartment $apartment): static
    {
        if (!$this->apartments->contains($apartment)) {
            $this->apartments->add($apartment);
            $apartment->setBuilding($this);
        }

        return $this;
    }

    public function removeApartment(Apartment $apartment): static
    {
        if ($this->apartments->removeElement($apartment)) {
            // set the owning side to null (unless already changed)
            if ($apartment->getBuilding() === $this) {
                $apartment->setBuilding(null);
            }
        }

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

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
