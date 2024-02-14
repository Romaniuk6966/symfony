<?php
namespace App\DataFixtures;

use App\Entity\Apartment;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ApartmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $buildings = $this->buildingArray();

        foreach ($buildings as $building) {
            $corp = $building['corp'];
            $buildObg = $building['obj'];
            $floors = $building['floors'];
            $apartmentOnFloor = $building['apartment_on_floor'];

            for ($c = 1; $c <= $corp; $c++) {
                for ($f = 1; $f <= $floors; $f++) {
                    for ($a = 1; $a <= $apartmentOnFloor; $a++) {
                        $rooms = rand(1, 5);
                        $livingSquareMeasurement = rand(60, 80) / 100;
                        $pricingGeneratorMeasurement = rand(30, 50) / 100;
                        $square = $this->squareRandomCalculate($rooms);
                        $livingSquare = $this->livingSquareRandomCalculate($square, $livingSquareMeasurement);
                        $price = $this->pricingGenerator($rooms, $square, $livingSquare, $f, $pricingGeneratorMeasurement);
                        $street = $building['street'];
                        $title = $street;
                        $title .= ' '.$rooms.' ';
                        $title .= (1 < $rooms)? 'rooms' : 'room';
                        $manager->persist(
                            (new Apartment())
                            ->setTitle($title)
                            ->setAddress($street)
                            ->setRooms($rooms)
                            ->setFloor($f)
                            ->setFloors($floors)
                            ->setPrice($price)
                            ->setSquare($square)
                            ->setLivingSquare($livingSquare)
                            ->setBuilding($buildObg)
                        );
                    }
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ BuildingFixtures::class ];
    }

    private function buildingArray(): array
    {
        return [
            'STOJARY_IVASIUKA_ST_17' => ['obj' => $this->getReference(BuildingFixtures::STOJARY_IVASIUKA_ST_17), 'street' => 'Ivasiuka St. 17', 'floors' => 9, 'corp' => 5, 'apartment_on_floor' => 4, 'year' => 2017],
            'PARK_ALLEY_SECHINOVA_3B' => ['obj' => $this->getReference(BuildingFixtures::PARK_ALLEY_SECHINOVA_3B), 'street' => 'Sechinova 3b', 'floors' => 10, 'corp' => 8, 'apartment_on_floor' => 2, 'year' => 2020],
            'SONIACHNY_DOVZENKA_ST_47' => ['obj' => $this->getReference(BuildingFixtures::SONIACHNY_DOVZENKA_ST_47), 'street' => 'Dovzenka St. 47', 'floors' => 11, 'corp' => 7, 'apartment_on_floor' => 3, 'year' => 2018],
            'PARK_ALLEY_SECHINOVA_129A' => ['obj' => $this->getReference(BuildingFixtures::PARK_ALLEY_SECHINOVA_129A), 'street' => 'Sechinova 129a', 'floors' => 11, 'corp' => 11, 'apartment_on_floor' => 4, 'year' => 2015],
            'MILLENNIUM_PRIOZERNA_ST_30' => ['obj' => $this->getReference(BuildingFixtures::MILLENNIUM_PRIOZERNA_ST_30), 'street' => 'Priozerna St. 30', 'floors' => 10, 'corp' => 6, 'apartment_on_floor' => 4, 'year' => 2023],
            'MILLENNIUM_PRIOZERNA_ST_29' => ['obj' => $this->getReference(BuildingFixtures::MILLENNIUM_PRIOZERNA_ST_29), 'street' => 'Priozerna St. 29', 'floors' => 11, 'corp' => 4, 'apartment_on_floor' => 3, 'year' => 2022],
            'MILLENNIUM_PRIOZERNA_ST_32' => ['obj' => $this->getReference(BuildingFixtures::MILLENNIUM_PRIOZERNA_ST_32), 'street' => 'Priozerna St. 32', 'floors' => 10, 'corp' => 6, 'apartment_on_floor' => 4, 'year' => 2021],
            'MILLENNIUM_PRIOZERNA_ST_24' => ['obj' => $this->getReference(BuildingFixtures::MILLENNIUM_PRIOZERNA_ST_24), 'street' => 'Priozerna St. 24', 'floors' => 10, 'corp' => 4, 'apartment_on_floor' => 3, 'year' => 2022],
            'VINOHRADNY_HETMANA_MAZEPY_175A' => ['obj' => $this->getReference(BuildingFixtures::VINOHRADNY_HETMANA_MAZEPY_175A), 'street' => 'Hetmana Mazepy 175a', 'floors' => 11, 'corp' => 3, 'apartment_on_floor' => 2, 'year' => 2015],
            'KALINOVA_SLOBODA_SLOBID_SKA_25' => ['obj' => $this->getReference(BuildingFixtures::KALINOVA_SLOBODA_SLOBID_SKA_25), 'street' => 'Slobid\'ska 25', 'floors' => 9, 'corp' => 5, 'apartment_on_floor' => 4, 'year' => 2019],
            'BULVAR_EVROPEYSKI_LENKAVSKY_ST_17G' => ['obj' => $this->getReference(BuildingFixtures::BULVAR_EVROPEYSKI_LENKAVSKY_ST_17G), 'street' => 'Lenkavsky St. 17g', 'floors' => 8, 'corp' => 6, 'apartment_on_floor' => 3, 'year' => 2015],
            'MISTECHKO_LYPKI_HETMANA_MAZEPY_160' => ['obj' => $this->getReference(BuildingFixtures::MISTECHKO_LYPKI_HETMANA_MAZEPY_160), 'street' => 'Hetmana Mazepy 160', 'floors' => 13, 'corp' => 7, 'apartment_on_floor' => 4, 'year' => 2021],
            'MISTECHKO_LYPKI_HETMANA_MAZEPY_162' => ['obj' => $this->getReference(BuildingFixtures::MISTECHKO_LYPKI_HETMANA_MAZEPY_162), 'street' => 'Hetmana Mazepy 162', 'floors' => 13, 'corp' => 6, 'apartment_on_floor' => 3, 'year' => 2021],
            'MISTECHKO_LYPKI_HETMANA_MAZEPY_164' => ['obj' => $this->getReference(BuildingFixtures::MISTECHKO_LYPKI_HETMANA_MAZEPY_164), 'street' => 'Hetmana Mazepy 164', 'floors' => 10, 'corp' => 4, 'apartment_on_floor' => 2, 'year' => 2019],
            'MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3' => ['obj' => $this->getReference(BuildingFixtures::MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3), 'street' => 'Hetmana Mazepy 164/3', 'floors' => 10, 'corp' => 5, 'apartment_on_floor' => 3, 'year' => 2018]
        ];
    }

    private function squareRandomCalculate($rooms): float
    {
        $randSquareArr = [
            [1, 0.4, 0.1, 1.1],
            [2, 0.6, 0.3, 1.0],
            [3, 0.7, 0.4, 0.9],
            [4, 0.8, 0.5, 0.85],
            [5, 0.9, 0.6, 0.8]
        ];

        $roomsCount = $randSquareArr[$rooms - 1][0];
        $roomsCountMinMeasurement = $randSquareArr[$rooms - 1][2];
        $roomsCountMaxMeasurement = $randSquareArr[$rooms - 1][1];
        $roomsCountGeneralMeasurement = $randSquareArr[$rooms - 1][3];

        $square = $roomsCount * rand(($roomsCount * 0.7 / $roomsCountMaxMeasurement * 10), ($roomsCount * 0.7 / $roomsCountMinMeasurement * 10)) * $roomsCountGeneralMeasurement;

        return number_format($square, 2);
    }

    private function livingSquareRandomCalculate($square, $livingSquareMeasurement = 0): float
    {
        $square = $square * $livingSquareMeasurement;

        return number_format($square, 2, '.', '');
    }

    private function pricingGenerator($rooms, $square, $livSquare, $floor, $randMeas): float
    {
        $price = ($rooms + rand(3, 7)) * $square * ($floor + rand(3, 7)) * $livSquare * $randMeas;

        if ($price < 10000) {
            $price = $price * 10;
        }

        return floatval(number_format($price, 2, '.', ''));
    }

    private function dateGenerator($year): DateTimeImmutable
    {
        $month = rand(1, 12);

        if (2 != $month) {
            if (in_array($month, [1, 3, 5, 7, 8, 10, 12])) {
                $day = rand(1, 31);
            } else {
                $day = rand(1, 30);
            }
        } else {
            $day = rand(1, 29);
        }

        $dateStr = $year;
        $dateStr .= '-'.sprintf("%02d", $month);
        $dateStr .= '-'.sprintf("%02d", $day);
        $dateStr .= ' '.sprintf("%02d", rand(0, 23));
        $dateStr .= ':'.sprintf("%02d", rand(0, 59));
        $dateStr .= ' Europe/London';

        return new DateTimeImmutable($dateStr);
    }
}
