<?php
namespace App\Exception;

use RuntimeException;

class ApartmentAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Apartment already exists");
    }
}