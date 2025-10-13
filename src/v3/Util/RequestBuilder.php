<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Request;

class RequestBuilder
{
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->request->setId($this->generateId());
    }

    private function generateId(): string
    {
        return uniqid('req_', true);
    }

    public function setId(string $id): self
    {
        $this->request->setId($id);
        return $this;
    }

    public function setTest(bool $test): self
    {
        $this->request->setTest($test ? 1 : 0);
        return $this;
    }

    public function setTimeout(int $milliseconds): self
    {
        $this->request->setTmax($milliseconds);
        return $this;
    }

    public function setAuctionType(AuctionType $type): self
    {
        $this->request->setAt($type);
        return $this;
    }

    /** @param list<string> $currencies */
    public function setCurrencies(array $currencies): self
    {
        $this->request->setCur($currencies);
        return $this;
    }

    /** @param list<string> $seats */
    public function setSeat(array $seats): self
    {
        $this->request->setSeat($seats);
        return $this;
    }

    public function setWseat(int $wseat): self
    {
        $this->request->setWseat($wseat);
        return $this;
    }

    public function setCdata(string $cdata): self
    {
        $this->request->setCdata($cdata);
        return $this;
    }

    public function addItem(Item $item): self
    {
        $this->request->addItem($item);
        return $this;
    }

    public function setSource(Source $source): self
    {
        $this->request->setSource($source);
        return $this;
    }

    public function setContext(Context $context): self
    {
        $this->request->setContext($context);
        return $this;
    }

    public function build(): Request
    {
        return $this->request;
    }

    public function toJson(): string|false
    {
        return $this->request->toJson();
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->request->toArray();
    }
}
