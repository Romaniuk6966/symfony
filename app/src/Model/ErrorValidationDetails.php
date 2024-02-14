<?php

namespace App\Model;

class ErrorValidationDetails
{
    private array $violations = [];

    public function addViolation(string $field, string $message): void
    {
        $this->violations[] = new ErrorViolationDetailsItem($field, $message);
    }

    /**
     * @return ErrorViolationDetailsItem[]
     */
    public function getViolations(): array
    {
        return $this->violations;
    }
}