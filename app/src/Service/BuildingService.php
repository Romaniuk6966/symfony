<?php
namespace App\Service;

use App\Entity\Building;
use App\Entity\Media;
use App\Exception\BuildingNotFoundException;
use App\Exception\MediaNotFoundException;
use App\Model\BuildingListItem;
use App\Model\BuildingListResponse;
use App\Model\BuildingRequest;
use App\Model\MediaListItem;
use App\Model\MediaListResponse;
use App\Repository\BuildingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\CacheInterface;

class BuildingService
{
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;
    private CacheInterface $cache;
    private BuildingRepository $buildingRepository;
    private MediaService $mediaService;

    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        CacheInterface $cache,
        BuildingRepository $buildingRepository,
        MediaService $mediaService
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->cache = $cache;
        $this->buildingRepository = $buildingRepository;
        $this->mediaService = $mediaService;
    }

    public function uploadThumbnail(Uuid $uuid, UploadedFile $file): MediaListResponse
    {
        $building = $this->buildingRepository->find($uuid);
        $media = $this->mediaService->upload($file);
        $building->setThumbnail($media);
        $this->entityManager->persist($building);
        $this->entityManager->flush();

        return new MediaListResponse([$this->mapThumbnailResponse($media)]);
    }

    public function fetchThumbnailByApartmentUuid(Uuid $uuid): MediaListResponse
    {
        $building = $this->buildingRepository->find($uuid);
        if (null === $building->getThumbnail()) {
            throw new MediaNotFoundException();
        }

        return new MediaListResponse([$this->mapThumbnailResponse($building->getThumbnail())]);
    }

    public function deleteThumbnail(Uuid $uuid): void
    {
        $building = $this->buildingRepository->find($uuid);
        if (null === $building->getThumbnail()) {
            throw new MediaNotFoundException();
        }

        $this->mediaService->delete($building->getThumbnail()->getId());
    }
    public function fetchBuildingByUuid(Uuid $uuid): BuildingListResponse
    {
        $building = $this->buildingRepository->find($uuid);
        if (null === $building) {
            throw new BuildingNotFoundException();
        }

        return new BuildingListResponse([$this->map($building)]);
    }

    public function add(BuildingRequest $buildingRequest): void
    {
        $building = new Building();
        $building->setTitle($buildingRequest->title);
        $building->setAddress($buildingRequest->address);
        $building->setLatitude($buildingRequest->latitude);
        $building->setLongitude($buildingRequest->longitude);
        $building->setFloors($buildingRequest->floors);
        $building->setYear($buildingRequest->year);

        $this->entityManager->persist($building);
        $this->entityManager->flush();
    }

    public function all(): BuildingListResponse
    {
        $buildings = $this->buildingRepository->findAll();
        $items = array_map([$this, 'map'], $buildings);

        return new BuildingListResponse($items);
    }

    public function delete(Uuid $uuid): void
    {
        $building = $this->entityManager->getRepository(Building::class)->find($uuid);
        $this->entityManager->remove($building);
        $this->entityManager->flush();
    }

    private function map(Building $building): BuildingListItem
    {
        return new BuildingListItem(
            $building->getId(),
            $building->getTitle(),
            $building->getAddress(),
            $building->getLatitude(),
            $building->getLongitude(),
            $building->getFloors(),
            $building->getYear()
        );
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
}
