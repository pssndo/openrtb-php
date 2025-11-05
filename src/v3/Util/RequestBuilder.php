<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Common\AbstractRequestBuilder;
use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Impression\Item;

/**
 * @extends AbstractRequestBuilder<Request>
 */
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

    /** @param Collection<string>|array<string> $cur */
    public function setCur(Collection|array $cur): static
    {
        $this->request->setCur($cur);

        return $this;
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        $this->request->setWseat($wseat);

        return $this;
    }

    /** @param Collection<string>|array<string> $bseat */
    public function setBseat(Collection|array $bseat): static
    {
        $this->request->setBseat($bseat);

        return $this;
    }

    /** @param Collection<string>|array<string> $badv */
    public function setBadv(Collection|array $badv): static
    {
        $this->request->setBadv($badv);

        return $this;
    }

    /** @param Collection<string>|array<string> $bapp */
    public function setBapp(Collection|array $bapp): static
    {
        $this->request->setBapp($bapp);

        return $this;
    }

    /** @param Collection<string>|array<string> $bcat */
    public function setBcat(Collection|array $bcat): static
    {
        $this->request->setBcat($bcat);

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

    public function setExt(Ext $ext): static
    {
        $this->request->setExt($ext);

        return $this;
    }
}
