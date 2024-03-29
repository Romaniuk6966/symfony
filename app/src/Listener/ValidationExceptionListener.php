<?php

namespace App\Listener;

use App\Exception\ValidationException;
use App\Model\ErrorResponse;
use App\Model\ErrorValidationDetails;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationExceptionListener
{
    private SerializerInterface $serializer;
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if(!($throwable instanceof ValidationException)) {
            return;
        }

        $data = $this->serializer->serialize(
            new ErrorResponse($throwable->getMessage(), $this->formatViolations($throwable->getViolations())),
            JsonEncoder::FORMAT
        );

        $event->setResponse(new JsonResponse($data, Response::HTTP_BAD_GATEWAY, [], true));
    }

    private function formatViolations(ConstraintViolationListInterface $violationList): ErrorValidationDetails
    {
        $details = new ErrorValidationDetails();

        foreach ($violationList as $violation) {
            $details->addViolation($violation->getPropertyPath(), $violation->getMessage());
        }

        return $details;
    }
}
