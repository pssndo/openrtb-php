<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\Interfaces\RequestBuilderInterface;
use OpenRTB\v3\Util\RequestBuilder;

class Factory
{
    public function createRequestBuilder(): RequestBuilderInterface
    {
        return new RequestBuilder();
    }
}
