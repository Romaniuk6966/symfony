<?php
namespace App\Controller\Api;

use App\Entity\Building;
use App\Model\ErrorResponse;
use LimitIterator;
use OpenApi\Attributes as OA;
use App\Attribute\RequestBody;
use App\Model\BuildingRequest;
use SplFileObject;
use Symfony\Component\Uid\Uuid;
use App\Service\BuildingService;
use App\Model\BuildingListResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuildingController extends AbstractApiController
{
    private BuildingService $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new Model(type: BuildingListResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Building not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function show(Uuid $uuid): JsonResponse
    {
        return $this->json($this->buildingService->fetchBuildingByUuid($uuid));
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Show all buildings',
        content: new Model(type: BuildingListResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Building not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function all(): JsonResponse
    {
        return $this->json($this->buildingService->all());
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 201,
        description: 'Add building',
    )]
    #[OA\Response(
        response: 400,
        description: 'Validation Failed',
        content: new Model(type: ErrorResponse::class)
    )]
    #[OA\RequestBody(content: new Model(type: BuildingRequest::class))]
    public function add(#[RequestBody] BuildingRequest $buildingRequest): JsonResponse
    {
        $this->buildingService->add($buildingRequest);

        return $this->json(['data' => 'Created'], 201);
    }

    public function delete(Uuid $uuid)
    {
        // TODO: Implement delete() method.
    }
}
