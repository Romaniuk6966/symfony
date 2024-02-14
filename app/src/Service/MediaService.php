<?php
namespace App\Service;

use App\Entity\Media;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Uid\Uuid;

class MediaService
{
    private FilesystemOperator $storage;
    private MediaRepository $mediaRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        FilesystemOperator $filesystemOperator,
        EntityManagerInterface $entityManager,
        MediaRepository $mediaRepository
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->storage = $filesystemOperator;
        $this->entityManager = $entityManager;
    }

    public function upload(UploadedFile $file): Media
    {
        $media = new Media();
        $media->setType($file->getClientMimeType());
        $media->setImageSize($file->getSize());
        $media->setImageFile($file);
        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }

    public function delete(Uuid $uuid): void
    {
        $media = $this->mediaRepository->find($uuid);
        $this->entityManager->remove($media);
        $this->entityManager->flush();
    }
}
