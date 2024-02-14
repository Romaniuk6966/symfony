<?php
namespace App\Entity;

use App\Repository\MediaRepository;
use App\Trait\RawLoader;
use App\Trait\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Uid\Uuid;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[Vich\Uploadable]
class Media
{
    use TimestampableEntity;
    use RawLoader;
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;
    #[ORM\Column(length: 255)]
    private ?string $type = null;
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $imageSize = null;
    #[Vich\UploadableField(mapping: 'media', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;
    #[ORM\Column(length: 255)]
    private ?string $imageName = null;
    #[ORM\OneToMany(mappedBy: 'thumbnail', targetEntity: Apartment::class)]
    private Collection $apartments;

    #[ORM\OneToMany(mappedBy: 'thumbnail', targetEntity: Building::class)]
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
    public function getImageSize(): ?string
    {
        return $this->imageSize;
    }
    public function setImageSize(string $imageSize): static
    {
        $this->imageSize = $imageSize;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile): static
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return Collection<int, Apartment>
     */
    public function getThumbnail(): Collection
    {
        return $this->apartments;
    }

    public function addThumbnail(Apartment $apartment): static
    {
        if (!$this->apartments->contains($apartment)) {
            $this->apartments->add($apartment);
            $apartment->setThumbnail($this);
        }

        return $this;
    }

    public function removeThumbnail(Apartment $apartment): static
    {
        if ($this->apartments->removeElement($apartment)) {
            // set the owning side to null (unless already changed)
            if ($apartment->getThumbnail() === $this) {
                $apartment->setThumbnail(null);
            }
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
            $building->setThumbnail($this);
        }

        return $this;
    }

    public function removeBuilding(Building $building): static
    {
        if ($this->buildings->removeElement($building)) {
            // set the owning side to null (unless already changed)
            if ($building->getThumbnail() === $this) {
                $building->setThumbnail(null);
            }
        }

        return $this;
    }
}
