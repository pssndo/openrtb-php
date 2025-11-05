<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Interfaces\RequestBuilderInterface;

/**
 * @template T of ObjectInterface
 */
abstract class AbstractRequestBuilder implements RequestBuilderInterface
{
    /** @var T */
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

    public function setExt(Ext $ext): static
    {
        $this->request->set('ext', $ext);

        return $this;
    }

    public function __invoke(): ObjectInterface
    {
        return $this->request;
    }
}
