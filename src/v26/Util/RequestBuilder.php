<?php

declare(strict_types=1);

namespace OpenRTB\v26\Util;

use OpenRTB\Common\AbstractRequestBuilder;
use OpenRTB\Common\Collection;
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Imp;

/**
 * @extends AbstractRequestBuilder<BidRequest>
 */
class RequestBuilder extends AbstractRequestBuilder
{
    public function __construct()
    {
        $this->request = new BidRequest();
        $this->request->setId(uniqid('req_', true));
    }

    public function addImp(Imp $imp): static
    {
        $imps = $this->request->getImp();
        if (null === $imps) {
            $imps = new Collection([], Imp::class);
        }
        $imps->add($imp);
        $this->request->setImp($imps);

        return $this;
    }

    public function setSite(Site $site): static
    {
        $this->request->setSite($site);
        $this->request->setApp(null);

        return $this;
    }

    public function setApp(App $app): static
    {
        $this->request->setApp($app);
        $this->request->setSite(null);

        return $this;
    }

    public function setDevice(Device $device): static
    {
        $this->request->setDevice($device);

        return $this;
    }

    public function setUser(User $user): static
    {
        $this->request->setUser($user);

        return $this;
    }

    public function setAt(AuctionType $at): static
    {
        $this->request->setAt($at);

        return $this;
    }

    public function setTmax(int $tmax): static
    {
        $this->request->setTmax($tmax);

        return $this;
    }

    /** @param Collection<string>|array<string> $cur */
    public function setCur(Collection|array $cur): static
    {
        $this->request->setCur((array) $cur);

        return $this;
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        $this->request->setWseat((array) $wseat);

        return $this;
    }

    /** @param Collection<string>|array<string> $bseat */
    public function setBseat(Collection|array $bseat): static
    {
        $this->request->setBseat((array) $bseat);

        return $this;
    }

    public function setAllimps(int $allimps): static
    {
        $this->request->setAllimps($allimps);

        return $this;
    }

    /** @param Collection<string>|array<string> $wlang */
    public function setWlang(Collection|array $wlang): static
    {
        $this->request->setWlang((array) $wlang);

        return $this;
    }

    /** @param Collection<string>|array<string> $wlangb */
    public function setWlangb(Collection|array $wlangb): static
    {
        $this->request->setWlangb((array) $wlangb);

        return $this;
    }

    /** @param Collection<string>|array<string> $bcat */
    public function setBcat(Collection|array $bcat): static
    {
        $this->request->setBcat((array) $bcat);

        return $this;
    }

    /** @param Collection<string>|array<string> $badv */
    public function setBadv(Collection|array $badv): static
    {
        $this->request->setBadv((array) $badv);

        return $this;
    }

    /** @param Collection<string>|array<string> $bapp */
    public function setBapp(Collection|array $bapp): static
    {
        $this->request->setBapp((array) $bapp);

        return $this;
    }

    public function setRegs(Regs $regs): static
    {
        $this->request->setRegs($regs);

        return $this;
    }

    public function setSource(Source $source): static
    {
        $this->request->setSource($source);

        return $this;
    }
}
