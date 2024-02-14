<?php
namespace App\Tests\Listener;

use App\Listener\ApiExceptionListener;
use App\Model\ErrorDebugDetails;
use App\Model\ErrorResponse;
use App\Service\ExceptionHandler\ExceptionMapping;
use App\Service\ExceptionHandler\ExceptionMappingResolver;
use App\Tests\AbstractTestCase;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListenerTest extends AbstractTestCase
{
    public function testNon500MappingWithHiddenMessage(): void
    {
        $mapping = ExceptionMapping::fromCode(Response::HTTP_NOT_FOUND);
        $responseMessage = Response::$statusTexts[$mapping->getCode()];
        $responseBody = json_encode(['error' => $responseMessage]);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with(new ErrorResponse($responseMessage), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $event = $this->createEvent(new InvalidArgumentException('test'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, false);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    public function testNon500MappingWithPublicMessage(): void
    {
        $mapping = new ExceptionMapping(Response::HTTP_NOT_FOUND, false, false);
        $responseMessage = 'test';
        $responseBody = json_encode(['error' => $responseMessage]);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with(new ErrorResponse($responseMessage), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $event = $this->createEvent(new InvalidArgumentException('test'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, false);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    public function testNon500LoggableMappingTriggersLogger(): void
    {
        $mapping = new ExceptionMapping(Response::HTTP_NOT_FOUND, false, true);
        $responseMessage = 'test';
        $responseBody = json_encode(['error' => $responseMessage]);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with(new ErrorResponse($responseMessage), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $logger->expects($this->once())
            ->method('error');

        $event = $this->createEvent(new InvalidArgumentException('test'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, false);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    public function test500IsLoggable(): void
    {
        $mapping = ExceptionMapping::fromCode(Response::HTTP_GATEWAY_TIMEOUT);
        $responseMessage = Response::$statusTexts[$mapping->getCode()];
        $responseBody = json_encode(['error' => $responseMessage]);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with(new ErrorResponse($responseMessage), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $logger->expects($this->once())
            ->method('error')
            ->with('error message', $this->anything());

        $event = $this->createEvent(new InvalidArgumentException('error message'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, false);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_GATEWAY_TIMEOUT, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    public function test500IsDefaultWhenMappingNotFound(): void
    {
        $responseMessage = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        $responseBody = json_encode(['error' => $responseMessage]);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn(null);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with(new ErrorResponse($responseMessage), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $logger->expects($this->once())
            ->method('error')
            ->with('error message', $this->anything());

        $event = $this->createEvent(new InvalidArgumentException('error message'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, false);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    public function testShowTraceWhenDebug(): void
    {
        $mapping = ExceptionMapping::fromCode(Response::HTTP_NOT_FOUND);
        $responseMessage = Response::$statusTexts[$mapping->getCode()];
        $responseBody = json_encode(['error' => $responseMessage, 'trace' => 'something']);

        $resolver = $this->createMock(ExceptionMappingResolver::class);
        $resolver->expects($this->once())
            ->method('resolve')
            ->with(InvalidArgumentException::class)
            ->willReturn($mapping);

        $logger = $this->createMock(LoggerInterface::class);
        $serializer = $this->createMock(SerializerInterface::class);
        $serializer->expects($this->once())
            ->method('serialize')
            ->with($this->callback(function (ErrorResponse $response) use ($responseMessage) {
                return $response->getMessage() == $responseMessage &&
                    $response->getDetails() instanceof ErrorDebugDetails &&
                    !empty($response->getDetails()->getTrace());
            }), JsonEncoder::FORMAT)
            ->willReturn($responseBody);

        $event = $this->createEvent(new InvalidArgumentException('error message'));

        $listener = new ApiExceptionListener($resolver, $logger, $serializer, true);
        $listener($event);

        $response = $event->getResponse();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertJsonStringEqualsJsonString($responseBody, $response->getContent());
    }

    private function createEvent(InvalidArgumentException $e): ExceptionEvent
    {
        return new ExceptionEvent(
            $this->createTestKernel(),
            new Request(),
            HttpKernelInterface::MAIN_REQUEST,
            $e
        );
    }

    protected function createTestKernel(): HttpKernelInterface
    {
        return new class() implements HttpKernelInterface {
            public function handle(Request $request, int $type = self::MAIN_REQUEST, bool $catch = true): Response
            {
                return new Response('test');
            }
        };
    }
}
