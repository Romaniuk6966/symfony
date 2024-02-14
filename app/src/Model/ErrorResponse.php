<?php
namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;

class ErrorResponse
{
    private string $message;
    private mixed $details;

    public function __construct(string $message, mixed $details = null)
    {
        $this->message = $message;
        $this->details = $details;
    }

    public function getMessage(): string
    {
        return $this->message;
    }


    #[OA\Property(
        type: "object",
        oneOf: [
            new OA\Schema(ref: new Model(type: ErrorDebugDetails::class)),
            new OA\Schema(ref: new Model(type: ErrorValidationDetails::class)),
        ]
    )]
    public function getDetails(): mixed
    {
        return $this->details;
    }
}