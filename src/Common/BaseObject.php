<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Interfaces\ObjectInterface;

class BaseObject implements ObjectInterface
{
    use HasData;

    public static function getSchema(): array
    {
        return static::$schema ?? [];
    }
}