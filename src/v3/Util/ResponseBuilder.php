<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Response;

class ResponseBuilder
{
    private Response $response;

    public function __construct(string $requestId)
    {
        $this->response = new Response();
        $this->response->setId($requestId);
    }

    public function setBidId(string $bidId): self
    {
        $this->response->setBidid($bidId);
        return $this;
    }

    public function setNoBidReason(NoBidReason $nbr): self
    {
        $this->response->setNbr($nbr);
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->response->setCur($currency);
        return $this;
    }

    public function setCdata(string $cdata): self
    {
        $this->response->setCdata($cdata);
        return $this;
    }

    public function addSeatbid(Seatbid $seatbid): self
    {
        $this->response->addSeatbid($seatbid);
        return $this;
    }

    public function build(): Response
    {
        return $this->response;
    }

    public function toJson(): string|false
    {
        return $this->response->toJson();
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->response->toArray();
    }
}
