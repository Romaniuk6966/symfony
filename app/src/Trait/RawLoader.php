<?php

namespace App\Trait;

trait RawLoader
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
