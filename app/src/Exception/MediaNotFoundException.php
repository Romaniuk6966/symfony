<?php

namespace App\Exception;

use RuntimeException;

class MediaNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Media not found");
    }
}