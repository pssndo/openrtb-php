<?php

declare(strict_types=1);

namespace OpenRTB\v26\Util;

use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Ext;
use OpenRTB\v26\Response\SeatBid;

class BidResponseBuilder
{
    private BidResponse $bidResponse;

    public function __construct(string $requestId)
    {
        $this->bidResponse = new BidResponse();
        $this->bidResponse->setId($requestId);
        $this->bidResponse->setBidid(uniqid('resp_', true));
    }

    public function setBidId(string $bidId): self
    {
        $this->bidResponse->setBidid($bidId);
        return $this;
    }

    public function setCur(string $cur): self
    {
        $this->bidResponse->setCur($cur);
        return $this;
    }

    public function setNbr(int $nbr): self
    {
        $this->bidResponse->setNbr($nbr);
        return $this;
    }

    public function setExt(Ext $ext): self
    {
        $this->bidResponse->setExt($ext);
        return $this;
    }

    public function addSeatBid(SeatBid $seatBid): self
    {
        $seatBids = $this->bidResponse->getSeatbid() ?? [];
        $seatBids[] = $seatBid;
        $this->bidResponse->setSeatbid($seatBids);
        return $this;
    }

    public function build(): BidResponse
    {
        return $this->bidResponse;
    }
}
