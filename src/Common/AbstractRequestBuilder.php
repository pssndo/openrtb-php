<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Interfaces\RequestBuilderInterface;

abstract class AbstractRequestBuilder implements RequestBuilderInterface
{
    protected ObjectInterface $request;

    public function setId(string $id): static
    {
        $this->request->set('id', $id);
        return $this;
    }

    /**
     * @param bool|int $test Indicator of test mode. (0 = live, 1 = test). Integers will be converted.
     */
    public function setTest(bool|int $test): static
    {
        if (is_int($test) && !in_array($test, [0, 1], true)) {
            throw new \InvalidArgumentException('Invalid value for test. Must be 0 or 1.');
        }

        $this->request->set('test', (int) $test);
        return $this;
    }

    public function build(): ObjectInterface
    {
        return $this->request;
    }
}