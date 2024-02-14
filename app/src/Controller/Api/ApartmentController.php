<?php
namespace App\Controller\Api;

use App\Model\ErrorResponse;
use OpenApi\Attributes as OA;
use App\Attribute\RequestBody;
use Symfony\Component\Uid\Uuid;
use App\Model\ApartmentRequest;
use App\Service\ApartmentService;
use App\Model\ApartmentListResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Model\ApartmentListDetailResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApartmentController extends AbstractApiController
{
    private ApartmentService $apartmentService;

    public function __construct(ApartmentService $apartmentService)
    {
        $this->apartmentService = $apartmentService;
    }

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Show one apartment by UUID',
        content: new Model(type: ApartmentListDetailResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Apartment not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function show(Uuid $uuid): JsonResponse
    {
        $apartment = $this->apartmentService->fetchApartmentByUuid($uuid);

        return $this->json($apartment);
    }

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Show apartment list',
        content: new Model(type: ApartmentListResponse::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Apartment not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function all(): JsonResponse
    {
        $apartments = $this->apartmentService->all();
        return $this->json($apartments);
    }

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 201,
        description: 'Create new apartment'
    )]
    #[OA\Response(
        response: 400,
        description: 'Validation Failed',
        content: new Model(type: ErrorResponse::class)
    )]
    #[OA\RequestBody(content: new Model(type: ApartmentRequest::class))]
    public function add(#[RequestBody] ApartmentRequest $apartmentRequest): JsonResponse
    {
        $this->apartmentService->add($apartmentRequest);
        return $this->json(['data' => 'Created'], 201);
    }

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Remove an apartment'
    )]
    #[OA\Response(
        response: 404,
        description: 'Apartment not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function delete(Uuid $uuid): JsonResponse
    {
        $this->apartmentService->delete($uuid);
        return $this->json(['data' => 'Created'], 201);
    }
}
