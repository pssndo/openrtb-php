<?php

declare(strict_types=1);

namespace OpenRTB\v25\Util;

use OpenRTB\Common\AbstractParser;
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\BidResponse;

class Parser extends AbstractParser
{
    public function parseBidRequest(string $json): BidRequest
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        /** @var BidRequest $request */
        $request = $this->hydrate($data, BidRequest::class);

        return $request;
    }

    public function parseBidResponse(string $json): ?BidResponse
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        /** @var BidResponse $response */
        $response = $this->hydrate($data, BidResponse::class);

        return $response;
    }
}
