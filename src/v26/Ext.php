<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Ext implements ObjectInterface
{
    use HasData;

    public static function getSchema(): array
    {
        return [];
    }
}