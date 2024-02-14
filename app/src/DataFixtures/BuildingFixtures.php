<?php
namespace App\DataFixtures;

use App\Entity\Building;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class BuildingFixtures extends Fixture implements DependentFixtureInterface
{
    public const PARK_ALLEY_SECHINOVA_129A = 'PARK_ALLEY_SECHINOVA_129A';
    public const PARK_ALLEY_SECHINOVA_3B = 'PARK_ALLEY_SECHINOVA_3B';
    public const MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3 = 'MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3';
    public const MISTECHKO_LYPKI_HETMANA_MAZEPY_164 = 'MISTECHKO_LYPKI_HETMANA_MAZEPY_164';
    public const MISTECHKO_LYPKI_HETMANA_MAZEPY_160 = 'MISTECHKO_LYPKI_HETMANA_MAZEPY_160';
    public const MISTECHKO_LYPKI_HETMANA_MAZEPY_162 = 'MISTECHKO_LYPKI_HETMANA_MAZEPY_162';
    public const MILLENNIUM_PRIOZERNA_ST_30 = 'MILLENNIUM_PRIOZERNA_ST_30';
    public const MILLENNIUM_PRIOZERNA_ST_24 = 'MILLENNIUM_PRIOZERNA_ST_24';
    public const MILLENNIUM_PRIOZERNA_ST_32 = 'MILLENNIUM_PRIOZERNA_ST_32';
    public const MILLENNIUM_PRIOZERNA_ST_29 = 'MILLENNIUM_PRIOZERNA_ST_29';
    public const SONIACHNY_DOVZENKA_ST_47 = 'SONIACHNY_DOVZENKA_ST_47';
    public const KALINOVA_SLOBODA_SLOBID_SKA_25 = 'KALINOVA_SLOBODA_SLOBID_SKA_25';
    public const VINOHRADNY_HETMANA_MAZEPY_175A = 'VINOHRADNY_HETMANA_MAZEPY_175A';
    public const BULVAR_EVROPEYSKI_LENKAVSKY_ST_17G = 'BULVAR_EVROPEYSKI_LENKAVSKY_ST_17G';
    public const STOJARY_IVASIUKA_ST_17 = 'STOJARY_IVASIUKA_ST_17';

    public function load(ObjectManager $manager): void
    {
        $BRICK = $this->getReference(MetadataFixtures::BRICK);
        $PANEL = $this->getReference(MetadataFixtures::PANEL);
        $MONOLITH = $this->getReference(MetadataFixtures::MONOLITH);
        $SECURITY = $this->getReference(MetadataFixtures::SECURITY);
        $ELEVATOR = $this->getReference(MetadataFixtures::ELEVATOR);
        $INSULATED = $this->getReference(MetadataFixtures::INSULATED);
        $NEW_BUILDING = $this->getReference(MetadataFixtures::NEW_BUILDING);
        $UKRAINIAN_BRICK = $this->getReference(MetadataFixtures::UKRAINIAN_BRICK);
        $UNDERGROUND_PARKING = $this->getReference(MetadataFixtures::UNDERGROUND_PARKING);

        $_PARK_ALLEY_SECHINOVA_3B = $this->getReference(MediaFixtures::IMG_PARK_ALLEY_SECHINOVA_3B);
        $_PARK_ALLEY_SECHINOVA_129A = $this->getReference(MediaFixtures::IMG_PARK_ALLEY_SECHINOVA_129A);
        $_MISTECHKO_LYPKI_HETMANA_MAZEPY_162 = $this->getReference(MediaFixtures::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_162);
        $_MISTECHKO_LYPKI_HETMANA_MAZEPY_160 = $this->getReference(MediaFixtures::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_160);
        $_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3 = $this->getReference(MediaFixtures::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3);
        $_MILLENNIUM_PRIOZERNA_ST_29 = $this->getReference(MediaFixtures::IMG_MILLENNIUM_PRIOZERNA_ST_29);
        $_SONIACHNY_DOVZENKA_ST_47 = $this->getReference(MediaFixtures::IMG_SONIACHNY_DOVZENKA_ST_47);

        $buildings = [
            self::PARK_ALLEY_SECHINOVA_129A => (new Building())->setTitle('Park Alley')->setAddress('Sechinova 129a')->setLatitude(48.9166728)->setLongitude(24.7490272)->setFloors(11)->setYear(2015)->addAttribute($BRICK)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_PARK_ALLEY_SECHINOVA_129A),
            self::PARK_ALLEY_SECHINOVA_3B => (new Building())->setTitle('Park Alley')->setAddress('Sechinova 3b')->setLatitude(48.9166728)->setLongitude(24.7490272)->setFloors(10)->setYear(2020)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->setThumbnail($_PARK_ALLEY_SECHINOVA_3B),
            self::MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3 => (new Building())->setTitle('Mistechko Lypki')->setAddress('Hetmana Mazepy 164/3')->setLatitude(48.9101293)->setLongitude(24.6849346)->setFloors(10)->setYear(2018)->addAttribute($BRICK)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3),
            self::MISTECHKO_LYPKI_HETMANA_MAZEPY_164 => (new Building())->setTitle('Mistechko Lypki')->setAddress('Hetmana Mazepy 164')->setLatitude(48.9101293)->setLongitude(24.6849346)->setFloors(10)->setYear(2019)->addAttribute($BRICK)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3),
            self::MISTECHKO_LYPKI_HETMANA_MAZEPY_160 => (new Building())->setTitle('Mistechko Lypki')->setAddress('Hetmana Mazepy 160')->setLatitude(48.9102409)->setLongitude(24.6868427)->setFloors(13)->setYear(2021)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->addAttribute($SECURITY)->addAttribute($UNDERGROUND_PARKING)->setThumbnail($_MISTECHKO_LYPKI_HETMANA_MAZEPY_160),
            self::MISTECHKO_LYPKI_HETMANA_MAZEPY_162 => (new Building())->setTitle('Mistechko Lypki')->setAddress('Hetmana Mazepy 162')->setLatitude(48.9096668)->setLongitude(24.6854032)->setFloors(13)->setYear(2021)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->addAttribute($SECURITY)->addAttribute($UNDERGROUND_PARKING)->setThumbnail($_MISTECHKO_LYPKI_HETMANA_MAZEPY_162),
            self::MILLENNIUM_PRIOZERNA_ST_30 => (new Building())->setTitle('Millennium')->setAddress('Priozerna St. 30')->setLatitude(48.9096668)->setLongitude(24.6847165)->setFloors(10)->setYear(2023)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->addAttribute($SECURITY)->addAttribute($UNDERGROUND_PARKING)->setThumbnail($_MILLENNIUM_PRIOZERNA_ST_29),
            self::MILLENNIUM_PRIOZERNA_ST_24 => (new Building())->setTitle('Millennium')->setAddress('Priozerna St. 24')->setLatitude(48.9096668)->setLongitude(24.6847165)->setFloors(10)->setYear(2022)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->addAttribute($UNDERGROUND_PARKING)->setThumbnail($_MILLENNIUM_PRIOZERNA_ST_29),
            self::MILLENNIUM_PRIOZERNA_ST_32 => (new Building())->setTitle('Millennium')->setAddress('Priozerna St. 32')->setLatitude(48.9096668)->setLongitude(24.6847165)->setFloors(10)->setYear(2021)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->setThumbnail($_MILLENNIUM_PRIOZERNA_ST_29),
            self::MILLENNIUM_PRIOZERNA_ST_29 => (new Building())->setTitle('Millennium')->setAddress('Priozerna St. 29')->setLatitude(48.9096668)->setLongitude(24.6847165)->setFloors(11)->setYear(2022)->addAttribute($MONOLITH)->addAttribute($INSULATED)->addAttribute($ELEVATOR)->addAttribute($NEW_BUILDING)->addAttribute($SECURITY)->addAttribute($UNDERGROUND_PARKING)->setThumbnail($_MILLENNIUM_PRIOZERNA_ST_29),
            self::SONIACHNY_DOVZENKA_ST_47 => (new Building())->setTitle('Soniachny')->setAddress('Dovzenka St. 47')->setLatitude(48.906423)->setLongitude(24.6817232)->setFloors(10)->setYear(2018)->addAttribute($PANEL)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_SONIACHNY_DOVZENKA_ST_47),
            self::KALINOVA_SLOBODA_SLOBID_SKA_25 => (new Building())->setTitle('Kalinova Sloboda')->setAddress('Slobid\'ska 25')->setLatitude(48.9054145)->setLongitude(24.6756936)->setFloors(9)->setYear(2019)->addAttribute($BRICK)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->addAttribute($SECURITY)->setThumbnail($_SONIACHNY_DOVZENKA_ST_47),
            self::VINOHRADNY_HETMANA_MAZEPY_175A => (new Building())->setTitle('Vinohradny')->setAddress('Hetmana Mazepy 175a')->setLatitude(48.9016247)->setLongitude(24.6805576)->setFloors(11)->setYear(2015)->addAttribute($PANEL)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_SONIACHNY_DOVZENKA_ST_47),
            self::BULVAR_EVROPEYSKI_LENKAVSKY_ST_17G => (new Building())->setTitle('Bulvar Evropeyski')->setAddress('Lenkavsky St. 17g')->setLatitude(48.917638)->setLongitude(24.6908301)->setFloors(8)->setYear(2015)->addAttribute($PANEL)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_SONIACHNY_DOVZENKA_ST_47),
            self::STOJARY_IVASIUKA_ST_17 => (new Building())->setTitle('Stojary')->setAddress('Ivasiuka St. 17')->setLatitude(48.9298047)->setLongitude(24.7421931)->setFloors(9)->setYear(2017)->addAttribute($BRICK)->addAttribute($ELEVATOR)->addAttribute($INSULATED)->addAttribute($UKRAINIAN_BRICK)->setThumbnail($_SONIACHNY_DOVZENKA_ST_47)
        ];

        foreach ($buildings as $building) {
            $manager->persist($building);
        }

        $manager->flush();

        foreach ($buildings as $code => $building) {
            $this->addReference($code, $building);
        }
    }

    public function getDependencies(): array
    {
        return [
            MetadataFixtures::class,
            MediaFixtures::class
        ];
    }
}
