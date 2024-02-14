<?php
namespace App\Tests\Service;

use App\Entity\Apartment;
use App\Exception\BuildingNotFoundException;
use App\Model\ApartmentListItem;
use App\Model\ApartmentListResponse;
use App\Repository\ApartmentRepository;
use App\Repository\BuildingRepository;
use App\Service\ApartmentService;
use App\Service\MediaService;
use App\Tests\AbstractTestCase;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\CacheInterface;

class ApartmentServiceTest extends AbstractTestCase
{
    private EntityManager $entityManager;
    private LoggerInterface $logger;
    private CacheInterface $cache;
    private ApartmentRepository $apartmentRepository;
    private BuildingRepository $buildingRepository;
    private MediaService $mediaService;
    private const BUILDING_UUID = '6fb591e3-e8ba-4f72-a327-f8cd0f8cd276';
    private const APARTMENT_UUID = '55a04e0d-32cd-47cc-91aa-a1c385413aef';

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);
        $this->apartmentRepository = $this->createMock(ApartmentRepository::class);
        $this->buildingRepository = $this->createMock(BuildingRepository::class);
        $this->mediaService = $this->createMock(MediaService::class);
    }

    public function testGetApartmentsByBuildingNotFound(): void
    {
        $this->buildingRepository->expects($this->once())
            ->method('existsByUuid')
            ->with(Uuid::fromString(self::BUILDING_UUID))
            ->willReturn(false);

        $this->expectException(BuildingNotFoundException::class);
        (new ApartmentService($this->entityManager, $this->logger, $this->cache, $this->apartmentRepository, $this->buildingRepository, $this->mediaService))
            ->getApartmentsByBuilding(Uuid::fromString(self::BUILDING_UUID));
    }

    public function testGetApartmentsByBuilding(): void
    {
        $this->buildingRepository->expects($this->once())
            ->method('existsByUuid')
            ->with(Uuid::fromString(self::BUILDING_UUID))
            ->willReturn(true);

        $this->apartmentRepository->expects($this->once())
            ->method('findApartmentsByBuildingId')
            ->with(Uuid::fromString(self::BUILDING_UUID))
            ->willReturn([$this->createApartmentEntity()]);

        $service = new ApartmentService($this->entityManager, $this->logger, $this->cache, $this->apartmentRepository, $this->buildingRepository, $this->mediaService);
        $expected = new ApartmentListResponse([$this->createBookModel()]);

        $this->assertEquals($expected, $service->getApartmentsByBuilding(Uuid::fromString(self::BUILDING_UUID)));
    }

    private function createApartmentEntity(): Apartment
    {
        $apartment = (new Apartment())
            ->setTitle('Test apartment')
            ->setAddress('Test address')
            ->setRooms(1)
            ->setFloor(1)
            ->setFloors(1)
            ->setPrice(10000.0)
            ->setSquare(50.0)
            ->setLivingSquare(30.0);

        $this->setEntityId($apartment, Uuid::fromString(self::APARTMENT_UUID));

        return $apartment;
    }

    private function createBookModel(): ApartmentListItem
    {
        return (new ApartmentListItem(
            Uuid::fromString(self::APARTMENT_UUID),
            'Test apartment',
            'Test address',
            1,
            1,
            10000.0,
            50.0,
            30.0,
            1
        ));
    }
}