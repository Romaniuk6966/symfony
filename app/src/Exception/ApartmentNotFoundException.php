<?php
namespace App\Exception;

use RuntimeException;

class ApartmentNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Apartment not found");
    }
}