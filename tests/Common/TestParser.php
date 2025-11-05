<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\AbstractParser;
use OpenRTB\Interfaces\ObjectInterface;

class TestParser extends AbstractParser
{
    /**
     * @template T of ObjectInterface
     *
     * @param array<string, mixed> $data
     * @param class-string<T>      $class
     *
     * @return T
     */
    public function parse(array $data, string $class): ObjectInterface
    {
        return $this->hydrate($data, $class);
    }
}
