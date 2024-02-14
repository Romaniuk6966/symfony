<?php
namespace App\Listener;

use App\Model\ErrorDebugDetails;
use App\Model\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    private ExceptionMappingResolver $exceptionMappingResolver;
    private LoggerInterface $logger;
    private SerializerInterface $serializer;
    private bool $isDebug;

    public function __construct(ExceptionMappingResolver $exceptionMappingResolver, LoggerInterface $logger, SerializerInterface $serializer, bool $isDebug)
    {
        $this->exceptionMappingResolver = $exceptionMappingResolver;
        $this->logger = $logger;
        $this->serializer = $serializer;
        $this->isDebug = $isDebug;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        if ($this->isSecurityException($throwable)) {
            return;
        }

        $mapping = $this->exceptionMappingResolver->resolve(get_class($throwable));

        if (null === $mapping) {
            $mapping = ExceptionMapping::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($mapping->getCode() >= Response::HTTP_INTERNAL_SERVER_ERROR || $mapping->isLoggable()) {
            $this->logger->error($throwable->getMessage(), [
               'trace' => $throwable->getTraceAsString(),
               'previous' => null !== $throwable->getPrevious() ? $throwable->getPrevious()->getMessage() : ''
            ]);
        }

        $message = $mapping->isHidden() ? Response::$statusTexts[$mapping->getCode()] : $throwable->getMessage();
        $details = $this->isDebug ? new ErrorDebugDetails($throwable->getTraceAsString()) : null;
        $data = $this->serializer->serialize(new ErrorResponse($message, $details), JsonEncoder::FORMAT);

        $event->setResponse(new JsonResponse($data, $mapping->getCode(), [], true));
    }

    private function isSecurityException(\Throwable $throwable): bool
    {
        return $throwable instanceof AuthenticationException || $throwable instanceof AccessDeniedException;
    }
}