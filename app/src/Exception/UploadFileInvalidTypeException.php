<?php
namespace App\Exception;

use RuntimeException;

class UploadFileInvalidTypeException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct("Upload file type is invalid");
    }
}