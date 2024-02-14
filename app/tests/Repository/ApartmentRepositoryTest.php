<?php

namespace App\Tests\Repository;

use App\Entity\Apartment;
use App\Entity\Building;
use App\Repository\ApartmentRepository;
use App\Tests\AbstractRepositoryTest;

class ApartmentRepositoryTest extends AbstractRepositoryTest
{
    private ApartmentRepository $apartmentRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apartmentRepository = $this->getRepositoryForEntity(Apartment::class);
    }

    public function testFindApartmentsByBuildingId()
    {
        $building = (new Building())
            ->setTitle('Test apartment')
            ->setAddress('Test address')
            ->setLatitude(48.9166728)
            ->setLongitude(24.7490272)
            ->setFloors(5)
            ->setYear(2006);

        $this->entityManager->persist($building);

        for ($i = 0; $i < 5; $i++) {
            $apartment = $this->createApartment('Test Apartment #'.$i, 'Test address '.$i, $building);
            $this->entityManager->persist($apartment);
        }

        $this->entityManager->flush();
        $this->assertCount(5, $this->apartmentRepository->findApartmentsByBuildingId($building->getId()));

    }

    private function createApartment(string $title, string $address, Building $building): Apartment
    {
        return (new Apartment())
            ->setTitle($title)
            ->setAddress($address)
            ->setRooms(1)
            ->setFloor(1)
            ->setFloors(1)
            ->setPrice(10000.0)
            ->setSquare(50.0)
            ->setLivingSquare(30.0)
            ->setBuilding($building);
    }
}
