<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Ext implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }
}
