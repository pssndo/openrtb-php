<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

use OpenRTB\Common\AbstractParser;

interface OpenRTBFactoryInterface
{
    /**
     * Creates a BidRequest object for a specific OpenRTB version.
     *
     * @param array<string, mixed> $data
     */
    public function createBidRequest(array $data): BidRequestInterface;

    /**
     * Creates a BidResponse object for a specific OpenRTB version.
     *
     * @param array<string, mixed> $data
     */
    public function createBidResponse(array $data): BidResponseInterface;

    /**
     * Creates a parser for a specific OpenRTB version.
     */
    public function createParser(): AbstractParser;
}
