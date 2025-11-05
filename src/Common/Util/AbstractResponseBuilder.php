<?php

declare(strict_types=1);

namespace OpenRTB\Common\Util;

use OpenRTB\Interfaces\ObjectInterface;

/**
 * Abstract base class for response builders.
 * Provides common functionality for building OpenRTB response objects.
 */
abstract class AbstractResponseBuilder
{
    /**
     * The response object being built.
     */
    protected ObjectInterface $response;

    /**
     * Returns the built response object.
     * Subclasses should implement either this method or __invoke().
     */
    public function build(): ObjectInterface
    {
        return $this->response;
    }

    /**
     * Magic method to return the built response object.
     * Allows the builder to be invoked as a function.
     */
    public function __invoke(): ObjectInterface
    {
        return $this->build();
    }
}
