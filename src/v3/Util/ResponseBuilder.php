<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Common\Util\AbstractResponseBuilder;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Interfaces\ResponseBuilderInterface;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\BidResponse as Response;

class ResponseBuilder extends AbstractResponseBuilder implements ResponseBuilderInterface
{
    /** @var Response */
    protected ObjectInterface $response;

    public function __construct(string $requestId)
    {
        $this->response = new Response();
        $this->response->setId($requestId);
    }

    public function setBidId(string $bidId): static
    {
        $this->response->setBidid($bidId);
        return $this;
    }

    public function setNoBidReason(NoBidReason $nbr): static
    {
        $this->response->setNbr($nbr);
        return $this;
    }

    public function setCurrency(string $currency): static
    {
        $this->response->setCur($currency);
        return $this;
    }

    public function setCdata(string $cdata): static
    {
        $this->response->setCdata($cdata);
        return $this;
    }

    public function addSeatbid(Seatbid $seatbid): static
    {
        $this->response->addSeatbid($seatbid);
        return $this;
    }
}
