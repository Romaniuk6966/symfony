<?php
namespace App\Service;

use App\Entity\Apartment;
use App\Entity\Building;
use App\Entity\Media;
use App\Exception\BuildingNotFoundException;
use App\Exception\MediaNotFoundException;
use App\Model\ApartmentListItem;
use App\Model\ApartmentListResponse;
use App\Model\ApartmentListDetailResponse;
use App\Model\ApartmentRequest;
use App\Model\ApartmentDetailItem;
use App\Model\BuildingListItem;
use App\Model\BuildingListResponse;
use App\Model\MediaListItem;
use App\Model\MediaListResponse;
use App\Repository\ApartmentRepository;
use App\Repository\BuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\CacheInterface;

class ApartmentService
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    private CacheInterface $cache;
    private ApartmentRepository $apartmentRepository;
    private BuildingRepository $buildingRepository;
    private MediaService $mediaService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        CacheInterface $cache,
        ApartmentRepository $apartmentRepository,
        BuildingRepository $buildingRepository,
        MediaService $mediaService
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->cache = $cache;
        $this->apartmentRepository = $apartmentRepository;
        $this->buildingRepository = $buildingRepository;
        $this->mediaService = $mediaService;
    }

    public function uploadThumbnail(Uuid $uuid, UploadedFile $file): MediaListResponse
    {
        $apartment = $this->apartmentRepository->find($uuid);
        $media = $this->mediaService->upload($file);
        $apartment->setThumbnail($media);
        $this->entityManager->persist($apartment);
        $this->entityManager->flush();

        return new MediaListResponse([$this->mapThumbnailResponse($media)]);
    }

    public function fetchThumbnailByApartmentUuid(Uuid $uuid): MediaListResponse
    {
        $apartment = $this->apartmentRepository->find($uuid);
        if (null === $apartment->getThumbnail()) {
            throw new MediaNotFoundException();
        }

        return new MediaListResponse([$this->mapThumbnailResponse($apartment->getThumbnail())]);
    }

    public function deleteThumbnail(Uuid $uuid): void
    {
        $apartment = $this->apartmentRepository->find($uuid);
        if (null === $apartment->getThumbnail()) {
            throw new MediaNotFoundException();
        }

        $this->mediaService->delete($apartment->getThumbnail()->getId());
    }

    public function fetchApartmentByUuid(Uuid $uuid): ?ApartmentListDetailResponse
    {
        $apartment = $this->apartmentRepository->find($uuid);
        $items = array_map([$this, 'extendedMap'], [$apartment]);
        return new ApartmentListDetailResponse($items);
    }

    public function add(ApartmentRequest $apartmentRequest): void
    {
        $building = $this->getBuildingByUuid($apartmentRequest->buildingUuid);
        $apartment = (new Apartment())
            ->setTitle($apartmentRequest->title)
            ->setAddress($apartmentRequest->address)
            ->setRooms($apartmentRequest->rooms)
            ->setFloor($apartmentRequest->floor)
            ->setPrice($apartmentRequest->price)
            ->setFloors($apartmentRequest->floors)
            ->setSquare($apartmentRequest->square)
            ->setLivingSquare($apartmentRequest->living_square)
            ->setPrice($apartmentRequest->price)
            ->setBuilding($building);
        $this->entityManager->persist($apartment);
        $this->entityManager->flush();
    }

    public function delete(Uuid $uuid): void
    {
        $apartment = $this->apartmentRepository->find($uuid);
        $this->entityManager->remove($apartment);
        $this->entityManager->flush();
    }

    public function all(): ApartmentListResponse
    {
        $apartments = $this->apartmentRepository->findAll();
        $items = array_map([$this, 'map'], $apartments);

        return new ApartmentListResponse($items);
    }

    public function getApartmentsByBuilding(Uuid $uuid): ApartmentListResponse
    {
        if (!$this->buildingRepository->existsByUuid($uuid)) {
            throw new BuildingNotFoundException();
        }

        return new ApartmentListResponse(array_map(
            [$this, 'map'],
            $this->apartmentRepository->findApartmentsByBuildingId($uuid)
        ));
    }

    private function mapThumbnailResponse(Media $media): MediaListItem
    {
        return new MediaListItem(
            $media->getId(),
            $media->getType(),
            $media->getImageSize(),
            $media->getImageName()
        );
    }

    private function extendedMap(Apartment $apartment): ApartmentDetailItem
    {
        $media = null;
        $building = null;

        if (null !== $apartment->getThumbnail()) {
            $media = new MediaListResponse([
                new MediaListItem(
                    $apartment->getThumbnail()->getId(),
                    $apartment->getThumbnail()->getType(),
                    $apartment->getThumbnail()->getImageSize(),
                    $apartment->getThumbnail()->getImageName()
                )
            ]);
        }

        if (null !== $apartment->getBuilding()) {
            $building = new BuildingListResponse([
                new BuildingListItem(
                    $apartment->getBuilding()->getId(),
                    $apartment->getBuilding()->getTitle(),
                    $apartment->getBuilding()->getAddress(),
                    $apartment->getBuilding()->getLatitude(),
                    $apartment->getBuilding()->getLongitude(),
                    $apartment->getBuilding()->getFloors(),
                    $apartment->getBuilding()->getYear()
                )
            ]);
        }

        return new ApartmentDetailItem(
            $apartment->getId(),
            $apartment->getTitle(),
            $apartment->getAddress(),
            $apartment->getFloor(),
            $apartment->getRooms(),
            $apartment->getPrice(),
            $apartment->getSquare(),
            $apartment->getLivingSquare(),
            $apartment->getFloors(),
            $media,
            $building
        );
    }

    private function map(Apartment $apartment): ApartmentListItem
    {
        return new ApartmentListItem(
            $apartment->getId(),
            $apartment->getTitle(),
            $apartment->getAddress(),
            $apartment->getFloor(),
            $apartment->getRooms(),
            $apartment->getPrice(),
            $apartment->getSquare(),
            $apartment->getLivingSquare(),
            $apartment->getFloors()
        );
    }

    private function getBuildingByUuid(Uuid $uuid): ?Building
    {
        return $this->buildingRepository->find($uuid);
    }
}
