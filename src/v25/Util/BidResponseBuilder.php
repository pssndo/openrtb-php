<?php

declare(strict_types=1);

namespace OpenRTB\v25\Util;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Util\AbstractResponseBuilder;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\SeatBid;

class BidResponseBuilder extends AbstractResponseBuilder
{
    /** @var BidResponse */
    protected ObjectInterface $response;

    public function __construct(string $requestId)
    {
        $this->response = new BidResponse();
        $this->response->setId($requestId);
        $this->response->setBidid(uniqid('resp_', true));
    }

    public function setBidId(string $bidId): static
    {
        $this->response->setBidid($bidId);

        return $this;
    }

    public function setCur(string $cur): static
    {
        $this->response->setCur($cur);

        return $this;
    }

    public function setNbr(int $nbr): static
    {
        $this->response->setNbr($nbr);

        return $this;
    }

    public function setExt(Ext $ext): static
    {
        $this->response->setExt($ext);

        return $this;
    }

    public function addSeatBid(SeatBid $seatBid): static
    {
        $seatBids = $this->response->getSeatbid() ?? [];
        $seatBids[] = $seatBid;
        $this->response->setSeatbid($seatBids);

        return $this;
    }
}
