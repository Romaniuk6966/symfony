<?php
namespace App\DataFixtures;

use App\Entity\Metadata;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MetadataFixtures extends Fixture
{
    public const SALE = 'SALE';
    public const BRICK = 'BRICK';
    public const PANEL = 'PANEL';
    public const MONOLITH = 'MONOLITH';
    public const ELEVATOR = 'ELEVATOR';
    public const SECURITY = 'SECURITY';
    public const SEPARABLE = 'SEPARABLE';
    public const INSULATED = 'INSULATED';
    public const FIRST_PASS = 'FIRST_PASS';
    public const NEW_BUILDING = 'NEW_BUILDING';
    public const DESIGN_REPAIR = 'DESIGN_REPAIR';
    public const FROM_BUILDERS = 'FROM_BUILDERS';
    public const FREE_PLANNING = 'FREE_PLANNING';
    public const EURORENOVATION = 'EURORENOVATION';
    public const UKRAINIAN_BRICK = 'UKRAINIAN_BRICK';
    public const WITHOUT_COMMISSION = 'WITHOUT_COMMISSION';
    public const UNDERGROUND_PARKING = 'UNDERGROUND_PARKING';
    public const CONTIGUOUS_SEPARATE = 'CONTIGUOUS_SEPARATE';

    public function load(ObjectManager $manager): void
    {
        $metadata = [
            self::SALE => (new Metadata())->setKey('sale')->setValue('Sale'),
            self::BRICK => (new Metadata())->setKey('brick')->setValue('Brick'),
            self::PANEL => (new Metadata())->setKey('panel')->setValue('Panel'),
            self::MONOLITH => (new Metadata())->setKey('monolith')->setValue('Monolith'),
            self::SECURITY => (new Metadata())->setKey('security')->setValue('Security'),
            self::ELEVATOR => (new Metadata())->setKey('elevator')->setValue('Elevator'),
            self::SEPARABLE => (new Metadata())->setKey('separable')->setValue('Separable'),
            self::INSULATED => (new Metadata())->setKey('insulated')->setValue('Insulated'),
            self::FIRST_PASS => (new Metadata())->setKey('first_pass')->setValue('First pass'),
            self::NEW_BUILDING => (new Metadata())->setKey('new_building')->setValue('New building'),
            self::FREE_PLANNING => (new Metadata())->setKey('free_planning')->setValue('Free planning'),
            self::DESIGN_REPAIR => (new Metadata())->setKey('design_repair')->setValue('Design repair'),
            self::FROM_BUILDERS => (new Metadata())->setKey('from_builders')->setValue('From builders'),
            self::EURORENOVATION => (new Metadata())->setKey('eurorenovation')->setValue('Eurorenovation'),
            self::UKRAINIAN_BRICK => (new Metadata())->setKey('ukrainian_brick')->setValue('Ukrainian brick'),
            self::WITHOUT_COMMISSION => (new Metadata())->setKey('without_commission')->setValue('without commission'),
            self::UNDERGROUND_PARKING => (new Metadata())->setKey('underground_parking')->setValue('Underground parking'),
            self::CONTIGUOUS_SEPARATE => (new Metadata())->setKey('contiguous_separate')->setValue('Contiguous separate')
        ];

        foreach ($metadata as $meta) {
            $manager->persist($meta);
        }

        $manager->flush();

        foreach ($metadata as $code => $meta) {
            $this->addReference($code, $meta);
        }
    }
}