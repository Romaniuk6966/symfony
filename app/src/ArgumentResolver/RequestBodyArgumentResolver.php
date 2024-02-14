<?php
namespace App\ArgumentResolver;

use App\Attribute\RequestBody;
use App\Exception\RequestBodyConvertException;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestBodyArgumentResolver implements ValueResolverInterface
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        if (count($argument->getAttributes(RequestBody::class, ArgumentMetadata::IS_INSTANCEOF)) > 0) {
            try {
                $model = $this->serializer->deserialize($request->getContent(), $argument->getType(), JsonEncoder::FORMAT);
            } catch (\Throwable $throwable) {
                throw new RequestBodyConvertException($throwable);
            }

            $errors = $this->validator->validate($model);
            if (count($errors)) {
                throw new ValidationException($errors);
            }

            return [$model];
        }

        return [];
    }
}

