<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Ext implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, mixed>
     */
    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }
}
