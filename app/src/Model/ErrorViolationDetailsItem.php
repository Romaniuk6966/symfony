<?php
namespace App\Model;

class ErrorViolationDetailsItem
{
    private string $field;
    private string $message;
    /**
     * @param string $field
     * @param string $message
     */
    public function __construct(string $field, string $message)
    {
        $this->message = $message;
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}