<?php
namespace App\Controller\Api;

use OpenApi\Attributes as OA;
use App\Model\ErrorResponse;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Uid\Uuid;

class MetadataApartmentController extends AbstractApiController
{

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 201,
        description: 'Add apartment attribute'
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


    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Remove attribute attached to apartment'
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

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Show attribute by apartment UUID'
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

    #[OA\Tag(name: "Apartment")]
    #[OA\Response(
        response: 200,
        description: 'Show attributes by apartment uuid'
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