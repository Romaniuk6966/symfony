<?php

namespace App\Entity;

use App\Repository\MetadataRepository;
use App\Trait\RawLoader;
use App\Trait\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MetadataRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Metadata
{
    use TimestampableEntity;
    use RawLoader;
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $key = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $value = null;

    #[ORM\ManyToMany(targetEntity: Apartment::class, mappedBy: 'attributes')]
    private Collection $apartments;

    #[ORM\ManyToMany(targetEntity: Building::class, mappedBy: 'attributes')]
    private Collection $buildings;

    public function __construct()
    {
        $this->apartments = new ArrayCollection();
        $this->buildings = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    public function setKey(string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

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
            $apartment->addAttribute($this);
        }

        return $this;
    }

    public function removeApartment(Apartment $apartment): static
    {
        if ($this->apartments->removeElement($apartment)) {
            $apartment->removeAttribute($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Building>
     */
    public function getBuildings(): Collection
    {
        return $this->buildings;
    }

    public function addBuilding(Building $building): static
    {
        if (!$this->buildings->contains($building)) {
            $this->buildings->add($building);
            $building->addAttribute($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): static
    {
        if ($this->buildings->removeElement($building)) {
            $building->removeAttribute($this);
        }

        return $this;
    }
}
