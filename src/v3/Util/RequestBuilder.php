<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Common\AbstractRequestBuilder;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Request;

class RequestBuilder extends AbstractRequestBuilder
{
    public function __construct()
    {
        $this->request = new Request();
        $this->request->setId(uniqid('req_', true));
    }

    public function setTmax(int $tmax): static
    {
        $this->request->setTmax($tmax);
        return $this;
    }

    public function setAt(AuctionType $at): static
    {
        $this->request->setAt($at);
        return $this;
    }

    /** @param list<string> $cur */
    public function setCur(array $cur): static
    {
        $this->request->setCur($cur);
        return $this;
    }

    /** @param list<string> $seat */
    public function setSeat(array $seat): static
    {
        $this->request->setSeat($seat);
        return $this;
    }

    public function setWseat(int $wseat): static
    {
        $this->request->setWseat($wseat);
        return $this;
    }

    public function setCdata(string $cdata): static
    {
        $this->request->setCdata($cdata);
        return $this;
    }

    public function setSource(Source $source): static
    {
        $this->request->setSource($source);
        return $this;
    }

    public function setContext(Context $context): static
    {
        $this->request->setContext($context);
        return $this;
    }

    public function addItem(Item $item): static
    {
        $this->request->addItem($item);
        return $this;
    }
}