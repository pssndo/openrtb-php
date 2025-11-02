<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

use OpenRTB\Common\AbstractParser;

interface OpenRTBFactoryInterface
{
    /**
     * Creates a BidRequest object for a specific OpenRTB version.
     * @param array<string, mixed> $data
     * @return BidRequestInterface
     */
    public function createBidRequest(array $data): BidRequestInterface;

    /**
     * Creates a BidResponse object for a specific OpenRTB version.
     * @param array<string, mixed> $data
     * @return BidResponseInterface
     */
    public function createBidResponse(array $data): BidResponseInterface;

    /**
     * Creates a parser for a specific OpenRTB version.
     * @return AbstractParser
     */
    public function createParser(): AbstractParser;
}
