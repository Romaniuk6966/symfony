<?php
namespace App\ArgumentResolver;

use App\Attribute\RequestFile;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestFileArgumentResolver implements ValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): array
    {
        if (count($argument->getAttributes(RequestFile::class, ArgumentMetadata::IS_INSTANCEOF)) > 0) {
            $attribute = $argument->getAttributes(RequestFile::class, ArgumentMetadata::IS_INSTANCEOF)[0];
            $uploadFile = $request->files->get($attribute->getField());

            $errors = $this->validator->validate($uploadFile, $attribute->getConstraints());

            if (count($errors) > 0) {
                throw new ValidationException($errors);
            }

            return [$uploadFile];
        }

        return [];
    }
}

