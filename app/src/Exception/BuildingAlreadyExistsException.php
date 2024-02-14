<?php
namespace App\Exception;

use RuntimeException;

class BuildingAlreadyExistsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Building already exists");
    }
}