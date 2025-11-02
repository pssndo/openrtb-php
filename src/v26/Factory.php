<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Interfaces\RequestBuilderInterface;
use OpenRTB\v26\Util\RequestBuilder;

class Factory
{
    public function __invoke(): RequestBuilderInterface
    {
        return new RequestBuilder();
    }
}
