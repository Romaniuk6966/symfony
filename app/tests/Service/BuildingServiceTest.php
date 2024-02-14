<?php
namespace App\Tests\Service;

use App\Entity\Building;
use App\Model\BuildingListItem;
use App\Model\BuildingListResponse;
use App\Repository\BuildingRepository;
use App\Service\BuildingService;
use App\Service\MediaService;
use App\Tests\AbstractTestCase;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Cache\CacheInterface;

class BuildingServiceTest extends AbstractTestCase
{
    private EntityManager $entityManager;
    private LoggerInterface $logger;
    private CacheInterface $cache;
    private BuildingRepository $buildingRepository;
    private MediaService $mediaService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->cache = $this->createMock(CacheInterface::class);
        $this->buildingRepository = $this->createMock(BuildingRepository::class);
        $this->mediaService = $this->createMock(MediaService::class);
    }

    /**
     * @dataProvider buildingDataProvider
     */
    public function testAll($buildings): void
    {
        $this->buildingRepository->expects($this->once())
            ->method('findAll')
            ->willReturn(array_map([$this, 'createBuildingEntity'], $buildings));

        $service = new BuildingService($this->entityManager, $this->logger, $this->cache, $this->buildingRepository, $this->mediaService);
        $expected = new BuildingListResponse(array_map(fn ($building) => new BuildingListItem(
            Uuid::fromString($building[0]),
            $building[1],
            $building[2],
            $building[3],
            $building[4],
            $building[5],
            $building[6]
        ), $buildings));

        $this->assertEquals($expected, $service->all());
    }

    private function createBuildingEntity($entityData): Building
    {
        $building = (new Building())
            ->setTitle($entityData[1])
            ->setAddress($entityData[2])
            ->setLatitude($entityData[3])
            ->setLongitude($entityData[4])
            ->setFloors($entityData[5])
            ->setYear($entityData[6]);

        $this->setEntityId($building, Uuid::fromString($entityData[0]));

        return $building;
    }

    public function buildingDataProvider(): array
    {
        return [
            [
                [
                    ['7f50ea54-320d-4a01-9b8f-6f574bb9ef6e', 'Test Building', 'Test Address', 48.9166728, 24.7490272, 10, 2020],
                    ['ccb06d54-a747-4bcd-83ec-85222e4f874c', 'Test Building 2', 'Test Address 2', 48.9166738, 24.7490282, 8, 2018],
                    ['638d9c4b-f1a0-40fb-bc36-fe6dc5f8d321', 'Test Building 3', 'Test Address 3', 48.9166748, 24.7490292, 5, 2015],
                    ['b1234780-286a-4afd-a225-eb6bda2f66b8', 'Test Building 4', 'Test Address 4', 48.9166718, 24.7490262, 25, 2023],
                    ['9477f3bf-57bf-4ff7-b746-fc2190fdcc0f', 'Test Building 5', 'Test Address 5', 48.9166708, 24.7490252, 5, 2021]
                ]
            ]
        ];
    }

}
