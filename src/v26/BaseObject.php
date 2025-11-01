<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

abstract class BaseObject implements ObjectInterface
{
    use HasData;

    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [];

    /**
     * @return array<string, class-string|array<class-string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }
}
