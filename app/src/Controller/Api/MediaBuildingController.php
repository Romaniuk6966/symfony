<?php
namespace App\Controller\Api;

use App\Model\ErrorResponse;
use OpenApi\Attributes as OA;
use App\Attribute\RequestFile;
use Symfony\Component\Uid\Uuid;
use App\Model\MediaListResponse;
use App\Service\BuildingService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaBuildingController extends AbstractApiController
{
    private BuildingService $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 201,
        description: 'Upload apartment thumbnail',
        content: new Model(type: MediaListResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Validation failed',
        content: new Model(type: ErrorResponse::class)
    )]
    public function add(#[RequestFile(
        field: 'thumbnail',
        constraints: [
            new NotNull(),
            new Image(maxSize: '15M', mimeTypes: ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
        ]
    )] UploadedFile $file, Uuid $uuid): JsonResponse
    {
        $media = $this->buildingService->uploadThumbnail($uuid, $file);
        return $this->json($media, 201);
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Show one thumbnail by apartment UUID',
        content: new Model(type: MediaListResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Thumbnail not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function show(Uuid $uuid): JsonResponse
    {
        $apartment = $this->buildingService->fetchThumbnailByApartmentUuid($uuid);
        return $this->json($apartment);
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Remove thumbnail attached to apartment'
    )]
    #[OA\Response(
        response: 404,
        description: 'Apartment not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function delete(Uuid $uuid): JsonResponse
    {
        $this->buildingService->deleteThumbnail($uuid);
        return $this->json(['data' => true]);
    }

    public function all()
    {
        // TODO: Implement all() method.
    }
}