<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Common\AbstractParser;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\BidResponse as Response;

class Parser extends AbstractParser
{
    public static function parseBidRequest(string $json): Request
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $parser = new self();
        /** @var Request $request */
        $request = $parser->hydrate($data, Request::class);

        return $request;
    }

    public static function parseBidResponse(string $json): Response
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $parser = new self();
        /** @var Response $response */
        $response = $parser->hydrate($data, Response::class);

        return $response;
    }
}
