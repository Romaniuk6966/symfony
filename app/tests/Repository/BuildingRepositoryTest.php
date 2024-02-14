<?php
namespace App\Tests\Repository;

use App\Entity\Building;
use App\Repository\BuildingRepository;
use App\Tests\AbstractRepositoryTest;

class BuildingRepositoryTest extends AbstractRepositoryTest
{
    private BuildingRepository $buildingRepository;
    protected function setUp(): void
    {
        parent::setUp();

        $this->buildingRepository = $this->getRepositoryForEntity(Building::class);
    }

    public function testFindAll(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->entityManager->persist($this->createBuilding('Test Buildong #'.$i, 'Test building address #'.$i));
        }

        $this->entityManager->flush();
        $this->assertCount(5, $this->buildingRepository->findAll());
    }

    private function createBuilding(string $title, string $address): Building
    {
        return (new Building())
            ->setTitle($title)
            ->setAddress($address)
            ->setLatitude(48.9166728)
            ->setLongitude(24.7490272)
            ->setFloors(10)
            ->setYear(2020);
    }

}
