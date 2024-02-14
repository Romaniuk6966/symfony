<?php
namespace App\Controller\Api;

use App\Model\ErrorResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\Uid\Uuid;
use Nelmio\ApiDocBundle\Annotation\Model;

class MetadataBuildingController extends AbstractApiController
{
    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 201,
        description: 'Add building attribute'
    )]
    #[OA\Response(
        response: 404,
        description: 'Validation failed',
        content: new Model(type: ErrorResponse::class)
    )]
    public function add()
    {
        // TODO: Implement add() method.
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Remove attribute attached to building'
    )]
    #[OA\Response(
        response: 404,
        description: 'Attribute not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function delete(Uuid $uuid)
    {
        // TODO: Implement delete() method.
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Show attribute by building UUID'
    )]
    #[OA\Response(
        response: 404,
        description: 'Attribute not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function show(Uuid $uuid)
    {
        // TODO: Implement show() method.
    }

    #[OA\Tag(name: "Building")]
    #[OA\Response(
        response: 200,
        description: 'Show attributes by building UUID'
    )]
    #[OA\Response(
        response: 404,
        description: 'Attributes not found',
        content: new Model(type: ErrorResponse::class)
    )]
    public function all()
    {
        // TODO: Implement all() method.
    }
}