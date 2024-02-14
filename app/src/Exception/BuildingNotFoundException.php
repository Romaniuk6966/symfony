<?php

namespace App\Exception;

use RuntimeException;

class BuildingNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Building not found");
    }
}