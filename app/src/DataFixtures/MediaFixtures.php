<?php
namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaFixtures extends Fixture
{
    public const IMG_PARK_ALLEY_SECHINOVA_3B = 'IMG_PARK_ALLEY_SECHINOVA_3B';
    public const IMG_PARK_ALLEY_SECHINOVA_129A = 'IMG_PARK_ALLEY_SECHINOVA_129A';
    public const IMG_SONIACHNY_DOVZENKA_ST_47 = 'IMG_SONIACHNY_DOVZENKA_ST_47';
    public const IMG_MILLENNIUM_PRIOZERNA_ST_29 = 'IMG_MILLENNIUM_PRIOZERNA_ST_29';
    public const IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_160 = 'IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_160';
    public const IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_162 = 'IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_162';
    public const IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3 = 'IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3';

    public function load(ObjectManager $manager)
    {
        $park_alley_sechinova_3b = new UploadedFile(__DIR__.'/data/img/PARK_ALLEY_SECHINOVA_3B.jpeg', 'PARK_ALLEY_SECHINOVA_3B.jpeg');
        $park_alley_sechinova_129a = new UploadedFile(__DIR__.'/data/img/PARK_ALLEY_SECHINOVA_129A.jpeg', 'PARK_ALLEY_SECHINOVA_129A.jpeg');
        $soniachny_dovzenka_st_47 = new UploadedFile(__DIR__.'/data/img/SONIACHNY_DOVZENKA_ST_47.jpeg', 'SONIACHNY_DOVZENKA_ST_47.jpeg');
        $millennium_priozerna_st_29 = new UploadedFile(__DIR__.'/data/img/MILLENNIUM_PRIOZERNA_ST_29.jpeg', 'MILLENNIUM_PRIOZERNA_ST_29.jpeg');
        $mistechko_lypki_hetmana_mazepy_160 = new UploadedFile(__DIR__.'/data/img/MISTECHKO_LYPKI_HETMANA_MAZEPY_160.jpeg', 'MISTECHKO_LYPKI_HETMANA_MAZEPY_160.jpeg');
        $mistechko_lypki_hetmana_mazepy_162 = new UploadedFile(__DIR__.'/data/img/MISTECHKO_LYPKI_HETMANA_MAZEPY_162.jpeg', 'MISTECHKO_LYPKI_HETMANA_MAZEPY_162.jpeg');
        $mistechko_lypki_hetmana_mazepy_164_3 = new UploadedFile(__DIR__.'/data/img/MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3.jpeg', 'MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3.jpeg');

        $media = [
            self::IMG_PARK_ALLEY_SECHINOVA_3B => (new Media())->setType($park_alley_sechinova_3b->getMimeType())->setImageName($park_alley_sechinova_3b->getFilename())->setImageSize($park_alley_sechinova_3b->getSize())->setImageFile($park_alley_sechinova_3b),
            self::IMG_PARK_ALLEY_SECHINOVA_129A => (new Media())->setType($park_alley_sechinova_129a->getMimeType())->setImageName($park_alley_sechinova_129a->getFilename())->setImageSize($park_alley_sechinova_129a->getSize())->setImageFile($park_alley_sechinova_129a),
            self::IMG_SONIACHNY_DOVZENKA_ST_47 => (new Media())->setType($soniachny_dovzenka_st_47->getMimeType())->setImageName($soniachny_dovzenka_st_47->getFilename())->setImageSize($soniachny_dovzenka_st_47->getSize())->setImageFile($soniachny_dovzenka_st_47),
            self::IMG_MILLENNIUM_PRIOZERNA_ST_29 => (new Media())->setType($millennium_priozerna_st_29->getMimeType())->setImageName($millennium_priozerna_st_29->getFilename())->setImageSize($millennium_priozerna_st_29->getSize())->setImageFile($millennium_priozerna_st_29),
            self::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_160 => (new Media())->setType($mistechko_lypki_hetmana_mazepy_160->getMimeType())->setImageName($mistechko_lypki_hetmana_mazepy_160->getFilename())->setImageSize($mistechko_lypki_hetmana_mazepy_160->getSize())->setImageFile($mistechko_lypki_hetmana_mazepy_160),
            self::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_162 => (new Media())->setType($mistechko_lypki_hetmana_mazepy_162->getMimeType())->setImageName($mistechko_lypki_hetmana_mazepy_162->getFilename())->setImageSize($mistechko_lypki_hetmana_mazepy_162->getSize())->setImageFile($mistechko_lypki_hetmana_mazepy_162),
            self::IMG_MISTECHKO_LYPKI_HETMANA_MAZEPY_164_3 => (new Media())->setType($mistechko_lypki_hetmana_mazepy_164_3->getMimeType())->setImageName($mistechko_lypki_hetmana_mazepy_164_3->getFilename())->setImageSize($mistechko_lypki_hetmana_mazepy_164_3->getSize())->setImageFile($mistechko_lypki_hetmana_mazepy_164_3)
        ];

        foreach ($media as $img) {
            $manager->persist($img);
        }

        $manager->flush();

        foreach ($media as $code => $img) {
            $this->addReference($code, $img);
        }
    }
}